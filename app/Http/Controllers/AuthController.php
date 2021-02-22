<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthRegister;
use App\Http\Requests\AuthLogin;

class AuthController extends Controller
{
    protected $guard = 'api';

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
        $user = User::create([
            'name' => preg_replace('/\s+/', '', $validated['name']),
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json(
            $user
                ? ['success' => '创建用户成功']
                : ['error' => '创建用户失败']
        )->setStatusCode(201);
    }

    public function guest()
    {
        if (request('name')) {
            $faker = app(\Faker\Generator::class);

            $user = User::create([
                'name' => preg_replace('/\s+/', '', request('name')),
                'email' => $faker->email,
                'password' => bcrypt($faker->password),
            ]);

            $token = auth()->login($user);

            return $this->respondWithToken($token);
        }

        $user = User::find(2);
        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    /**
     * 登录并创建 JWT.
     *
     * @param  AuthLogin  $request
     * @return array|JsonResponse|object
     */
    public function login(AuthLogin $request)
    {
        $validated = $request->validated();

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];
        $rememberMeTtl = 60 * 24 * 7;
        $notMatchedText = '邮箱不存在或密码错误';

        $token = $validated['remember_me'] ? $this->guard()->setTTL($rememberMeTtl)->attempt($credentials) : $this->guard()->attempt($credentials);

        if (is_string($token)) {
            return array_merge([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ], auth()->user()->toArray());
        }

        return response()->json([
            'errors' => [
                'email' => [$notMatchedText],
                'password' => [$notMatchedText],
            ],
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
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * 获取 token 结构.
     *
     * @param  string  $token
     * @return array
     */
    protected function respondWithToken($token): array
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
}
