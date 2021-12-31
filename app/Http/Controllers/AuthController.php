<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AuthLogin;
use App\Http\Requests\AuthRegisterByEmail;
use App\Http\Requests\AuthRegisterByPhone;
use App\Http\Requests\Forget as ForgetRequest;
use App\Http\Requests\Reset;
use App\Mail\EmailVerify;
use App\Mail\Forget;
use App\Models\User;
use Cache;
use Faker\Generator;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Log;
use Mail;
use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Strategies\OrderStrategy;
use Str;

class AuthController extends Controller
{
    protected string $guard = 'api';

    /**
     * 创建用户。
     */
    public function registerByEmail(AuthRegisterByEmail $request): JsonResponse
    {
        $validated = $request->validated();

        // 创建用户
        $user = User::create([
            'name' => preg_replace('/\s+/', '', $validated['name']),
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $secret = Str::random(40);
        Cache::put('emailVerify:'.$secret, $user->id, 86400);
        $link = config('app.url').'/emailVerify/'.$secret;
        Mail::to($user->email)->send(new EmailVerify($user, $link));
        if (Mail::failures()) {
            Log::info(var_export(Mail::failures(), true));
        }

        return response()->json(
            $user
                ? ['success' => '创建用户成功']
                : ['error' => '创建用户失败']
        )->setStatusCode(201);
    }

    public function emailVerify(Request $request): JsonResponse|User
    {
        $userId = Cache::get('emailVerify:'.$request->secret);
        if ($userId) {
            $user = User::find($userId);
            $user->email_verified_at = Carbon::now();
            $user->save();

            return $user;
        }

        return response()->json()->setStatusCode(422);
    }

    public function autoLogin(Request $request): JsonResponse|array
    {
        $userId = Cache::get('emailVerify:'.$request->secret);
        if ($userId) {
            $user = User::find($userId);
            $token = auth()->login($user);

            return self::withProfile($token);
        }

        return response()->json()->setStatusCode(422);
    }

    /**
     * @param  string  $token
     * @return array
     */
    public static function withProfile(string $token): array
    {
        return array_merge(self::withToken($token), auth()->user()->toArray());
    }

    /**
     * 获取 token 结构.
     *
     * @param  string  $token
     * @return array
     */
    protected static function withToken(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];
    }

    /**
     * 创建用户通过手机号码
     */
    public function registerByPhone(
        AuthRegisterByPhone $request
    ): array|Application|ResponseFactory|JsonResponse|Response {
        $validated = $request->validated();

        $cacheKey = 'phone-'.$validated['phone_number'];

        if (Cache::get($cacheKey) !== $validated['verify']) {
            return response()->json(
                ['errors' => ['verify' => ['验证码错误']]]
            )->setStatusCode(422);
        }

        // 创建用户
        $user = User::create([
            'name' => preg_replace('/\s+/', '', $validated['name']),
            'phone_number' => $validated['phone_number'],
            'password' => bcrypt($validated['password']),
        ]);

        if ($user) {
            Cache::forget($cacheKey);

            return response($user, 201);
        }

        return [];
    }

    /**
     * 测试账号、聊天账号.
     *
     * @return array
     */
    public function guest(): array
    {
        if (request('name')) {
            $faker = app(Generator::class);

            $user = User::create([
                'name' => preg_replace('/\s+/', '', request('name')),
                'email' => $faker->email,
                'password' => bcrypt($faker->password),
            ]);
        } else {
            $user = User::find(2);
        }

        $token = auth()->login($user);

        return self::withProfile($token);
    }

    /**
     * 登录并创建 JWT
     */
    public function login(AuthLogin $request): array|JsonResponse
    {
        $rememberMeTtl = 60 * 24 * 7;
        $notMatchedText = '账号不存在或密码错误';

        $user = User::where('email', $request->account)
            ->orWhere(
                'phone_number',
                $request->account
            )->first();
        if ($user && $user['phone_number'] === null && $user->email_verified_at === null) {
            return response()->json([
                'error' => '请先验证邮箱再登录',
            ])->setStatusCode(422);
        }

        $validated = $request->validated();

        if (preg_match(config('preg.phone_number'), $validated['account'])) {
            $credentials = [
                'phone_number' => $validated['account'],
                'password' => $validated['password'],
            ];
        } elseif (filter_var($validated['account'], FILTER_VALIDATE_EMAIL)) {
            $credentials = [
                'email' => $validated['account'],
                'password' => $validated['password'],
            ];
        }

        $token = $validated['remember_me'] ? $this->guard()->setTTL($rememberMeTtl)->attempt($credentials) : $this->guard()->attempt($credentials);

        if (is_string($token)) {
            return self::withProfile($token);
        }

        return response()->json([
            'errors' => [
                'account' => [$notMatchedText],
                'password' => [$notMatchedText],
            ],
        ])->setStatusCode(422);
    }

    /**
     * 获取守卫.
     */
    public function guard(): Guard
    {
        return Auth::guard($this->guard);
    }

    public function profile(): ?Authenticatable
    {
        return auth()->user();
    }

    /**
     * 注销用户（使令牌无效）.
     */
    public function logout(): void
    {
        auth()->logout();
    }

    /**
     * 刷新 token.
     */
    public function refresh(): array
    {
        return self::withToken(auth()->refresh());
    }

    public function recaptcha(Request $request): void
    {
        $token = $request->token;

        $secret = config('services.recaptcha');

        $body = "secret=$secret&response=$token";
        $url = 'https://www.recaptcha.net/recaptcha/api/siteverify';
        $resp = $this->httpPost($url, $body);
        $resp = json_decode($resp, true);
        Log::info($url);
        Log::info($body);
        Log::info(var_export($resp, true));

        $key = 'recaptcha-'.$resp['hostname'];
        $score = $resp['success'] ? $resp['score'] : 0;
        Cache::put($key, $score, 86400);
    }

    public function httpPost($url, $postBody)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postBody);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public function phoneNumberVerify(Request $request): void
    {
        $phoneNumber = $request->phone_number;

        if (preg_match(config('preg.phone_number'), $phoneNumber) === false) {
            exit;
        }

        $recaptchaScore = Cache::get('recaptcha:'.$request->getClientIp(), 0);

        if ($recaptchaScore >= 0.5) {
            $this->sendSms($phoneNumber);
        }
    }

    public function sendSms($phoneNumber): void
    {
        $easySms = new EasySms([
            'timeout' => 5.0,
            'default' => [
                'strategy' => OrderStrategy::class,
                'gateways' => ['aliyun'],
            ],
            'gateways' => [
                'errorlog' => [
                    'file' => '/tmp/easy-sms.log',
                ],
                'aliyun' => [
                    'access_key_id' => config('services.access_key_id'),
                    'access_key_secret' => config('services.access_key_secret'),
                    'sign_name' => '技术笔记',
                ],
            ],
        ]);

        $random = random_int(1000, 9999);
        Cache::put('phone:'.$phoneNumber, $random, 86400);

        $easySms->send($phoneNumber, [
            'template' => 'SMS_212706541',
            'data' => [
                'code' => $random,
            ],
        ]);
    }

    /**
     * 将用户重定向到 GitHub 的授权页面
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->stateless()->redirect()->getTargetUrl();
    }

    /**
     * 从 GitHub 获取用户信息
     */
    public function handleProviderCallback(): array
    {
        $githubUser = Socialite::driver('github')->stateless()->user();

        $user = User::where('github_name', $githubUser->name)->firstOrCreate([
            'name' => $githubUser->name,
            'email' => $githubUser->email,
        ]);

        $token = auth()->login($user);

        return self::withProfile($token);
    }

    public function forget(ForgetRequest $request): JsonResponse
    {
        $user = User::where('email', $request->account)
            ->orWhere(
                'phone_number',
                $request->account
            )->first();
        if ($user) {
            $secret = Str::random(40);
            $link = config('app.frontend.url').'/forget/'.$secret;
            if ($user->email) {
                Mail::to($user->email)->send(new Forget($user, $link));
                if (Mail::failures()) {
                    return response()->json();
                }
                Cache::put('emailVerify:'.$secret, $user->id, 86400);
            }
            // 发送短信

            Cache::put('reset:'.$secret, $user->id, 86400);
        }

        return response()->json([]);
    }

    public function reset(Reset $request)
    {
        $userId = Cache::get('reset:'.$request->secret);
        if ($userId) {
            $user = User::find($userId);
            $user->password = bcrypt($request->password);
            $user->save();

            $token = auth()->login($user);

            return self::withProfile($token);
        }
    }
}
