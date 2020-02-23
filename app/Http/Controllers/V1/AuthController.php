<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;

class AuthController extends Controller
{
    protected $guard = 'api';

    public function __construct()
    {
        $this->middleware('refresh', ['except' => ['login', 'register', 'test']]);
    }

    public function test()
    {
        return $this->response->array([
            [
                'name' => 'lab-api',
                'content' => 'test'
            ]
        ]);
    }

    /**
     * 创建用户
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return \Illuminate\Http\JsonResponse
     */
    public function register()
    {
        $payload = request(['name', 'email', 'password', 'password_confirmation']);

        // 验证格式
        $rules = [
            'name' => ['required'],
            'email' => ['required', 'unique:users'],
            'password' => ['required', 'min:8', 'max:16'],
            'password_confirmation' => ['same:password']
        ];
        $validator = Validator::make($payload, $rules);
        if ($validator->fails()) {
            return $this->response->array(['error' => $validator->errors()]);
        }

        // 创建用户
        $user = User::create([
            'name' => $payload['name'],
            'email' => $payload['email'],
            'password' => bcrypt($payload['password']),
        ]);

        return $this->response->array($user
            ? ['success' => '创建用户成功']
            : ['error' => '创建用户失败']
        )->setStatusCode(201);
    }

    /**
     * 登录并创建 JWT
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        // 验证格式
        $rules = [
            'email' => ['required'],
            'password' => ['required', 'min:8', 'max:16'],
	        'remember_me' => 'boolean'
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return $this->response->array(['errors' => $validator->errors()])->setStatusCode(202);
        }

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return $this->response->array(['error' => '邮箱不存在或密码错误']);
    }

    /**
     * 获取已认证的用户信息
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return $this->response->array($this->guard()->user());
    }

    /**
     * 注销用户（使令牌无效）
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return $this->response->array(['message' => '成功退出']);
    }

    /**
     * 刷新 token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * 获取 token 结构
     *
     * @param  string  $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }


    /**
     * 获取守卫
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return \Auth::guard($this->guard);
    }
}
