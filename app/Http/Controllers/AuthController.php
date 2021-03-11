<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLogin;
use App\Http\Requests\AuthRegister;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected string $guard = 'api';

    /**
     * 创建用户.
     *
     * @param  AuthRegister  $request
     * @return JsonResponse
     */
    public function register(AuthRegister $request): JsonResponse
    {
        $validated = $request->validated();

        // 创建用户
        if ($validated['email'] ?? null) {
            $user = User::create([
                'name' => preg_replace('/\s+/', '', $validated['name']),
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
            ]);
        } elseif ($validated['phone'] ?? null) {
            $user = User::create([
                'name' => preg_replace('/\s+/', '', $validated['name']),
                'email' => $validated['phone'],
                'password' => bcrypt($validated['password']),
            ]);
        }

        return response()->json(
            $user
                ? ['success' => '创建用户成功']
                : ['error' => '创建用户失败']
        )->setStatusCode(201);
    }

    /**
     * 测试账号、聊天账号.
     * @return array
     */
    public function guest(): array
    {
        if (request('name')) {
            $faker = app(\Faker\Generator::class);

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
     * 登录并创建 JWT.
     *
     * @param  AuthLogin  $request
     * @return array|JsonResponse|object
     */
    public function login(AuthLogin $request)
    {
        $notMatchedText = '账号不存在或密码错误';

        $validated = $request->validated();

        $pattern = '/^((13\d)|(14[5-9])|(15([0-3]|[5-9]))|(16[6-7])|(17[1-8])|(18\d)|(19[1|3])|(19[5|6])|(19[8|9]))\d{8}$/';
        if (preg_match($pattern, $validated['account'], $matches)) {
            $credentials = [
                'phone' => $validated['account'],
                'password' => $validated['password'],
            ];
            $errorMsg = [
                'phone' => [$notMatchedText],
                'password' => [$notMatchedText],
            ];
        } elseif (filter_var($validated['account'], FILTER_VALIDATE_EMAIL)) {
            $credentials = [
                'email' => $validated['account'],
                'password' => $validated['password'],
            ];
            $errorMsg = [
                'email' => [$notMatchedText],
                'password' => [$notMatchedText],
            ];
        }

        $rememberMeTtl = 60 * 24 * 7;

        $token = ($validated['remember_me'] ?? false) ? $this->guard()->setTTL($rememberMeTtl)->attempt($credentials) : $this->guard()->attempt($credentials);

        if (is_string($token)) {
            return self::withProfile($token);
        }

        return response()->json([
            'errors' => $errorMsg,
        ])->setStatusCode(202);
    }

    /**
     * @return Authenticatable|null
     */
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
     * 获取守卫.
     *
     * @return Guard
     */
    public function guard(): Guard
    {
        return Auth::guard($this->guard);
    }

    /**
     * @param  string  $token
     * @return array
     */
    public static function withProfile(string $token): array
    {
        return array_merge(self::withToken($token), auth()->user()->toArray());
    }
}
