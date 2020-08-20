<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    protected $guard = 'api';

    /**
     * 创建用户.
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     */
    public function register()
    {
        $payload = request(['name', 'email', 'password', 'password_confirmation']);

        // 验证格式
        $rules = [
            'name' => [
                'required', 'not_regex:/\s+/', function ($attribute, $value, $fail) {
                    if (mb_strwidth($value) < 4 || mb_strwidth($value) > 16) {
                        $fail('昵称 宽度必须在 4 - 16 之间（一个中文文字为 2 个宽度）');
                    }
                }, ],
            'email' => ['required', 'not_regex:/\s+/', 'email', 'unique:users'],
            'password' => ['required', 'not_regex:/\s+/', 'min:8', 'max:16'],
            'password_confirmation' => ['same:password'],
        ];
        $validator = Validator::make($payload, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // 创建用户
        $user = User::create([
            'name' => preg_replace('/\s+/', '', $payload['name']),
            'email' => $payload['email'],
            'password' => bcrypt($payload['password']),
        ]);

        return response()->json(
            $user
                ? ['success' => '创建用户成功']
                : ['error' => '创建用户失败']
        )->setStatusCode(201);
    }

    /**
     * 登录并创建 JWT.
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        $rememberMe = request('remember_me');

        // 验证格式
        $rules = [
            'email' => ['required'],
            'password' => ['required', 'min:8', 'max:16'],
            'remember_me' => 'boolean',
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()])->setStatusCode(202);
        }

        $ttl = 60 * 24 * 7;
        $token = $rememberMe ? $this->guard()->setTTL($ttl)->attempt($credentials) : $this->guard()->attempt($credentials);

        if ($token) {
            return $this->respondWithToken($token);
        }

        $text = '邮箱不存在或密码错误';

        return response()->json([
            'errors' => [
                'email' => [$text],
                'password' => [$text],
            ],
        ])->setStatusCode(202);
    }

    /**
     * 获取已认证的用户信息.
     */
    public function profile()
    {
        return $this->guard()->user();
    }

    /**
     * 注销用户（使令牌无效）.
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => '成功退出']);
    }

    /**
     * 刷新 token.
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * 获取 token 结构.
     *
     * @param  string  $token
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60,
        ]);
    }

    /**
     * 获取守卫.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return \Auth::guard($this->guard);
    }

    public function recaptcha()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token'])) {
            $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
            $recaptcha_secret = config('auth.recaptcha');
            $token = $_POST['token'];

            $recaptcha = file_get_contents($recaptcha_url.'?secret='.$recaptcha_secret.'&response='.$token);
            $recaptcha = json_decode($recaptcha);

            if ($recaptcha->score >= 0.5) {
                Log::notice('yes');
            } else {
                Log::notice('no');
            }
        }
    }
}
