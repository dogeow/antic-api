<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    protected $guard = 'api';

    public function test()
    {
        return $this->response->array([
            [
                'name' => 'lab-api',
                'content' => 'test',
            ],
        ]);
    }

    /**
     * 创建用户.
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     *
     * @return Response
     */
    public function register()
    {
        $payload = request(['name', 'email', 'password', 'password_confirmation']);

        // 验证格式
        $rules = [
            'name' => ['required', 'not_regex:/\s+/'],
            'email' => ['required', 'not_regex:/\s+/', 'email', 'unique:users'],
            'password' => ['required', 'not_regex:/\s+/', 'min:8', 'max:16'],
            'password_confirmation' => ['same:password'],
        ];
        $validator = Validator::make($payload, $rules);
        if ($validator->fails()) {
            return $this->response->array(['errors' => $validator->errors()]);
        }

        // 创建用户
        $user = User::create([
            'name' => preg_replace('/\s+/', '', $payload['name']),
            'email' => $payload['email'],
            'password' => bcrypt($payload['password']),
        ]);

        return $this->response->array(
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
     *
     * @return Response
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
            return $this->response->array(['errors' => $validator->errors()])->setStatusCode(202);
        }

        if ($rememberMe) {
            $token = $this->guard()->setTTL(60 * 24 * 7)->attempt($credentials);
        } else {
            $token = $this->guard()->attempt($credentials);
        }

        if ($token) {
            return $this->respondWithToken($token);
        }

        return $this->response->array(['error' => '邮箱不存在或密码错误']);
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
     *
     * @return Response
     */
    public function logout()
    {
        $this->guard()->logout();

        return $this->response->array(['message' => '成功退出']);
    }

    /**
     * 刷新 token.
     *
     * @return Response
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * 获取 token 结构.
     *
     * @param  string  $token
     *
     * @return Response
     */
    protected function respondWithToken($token)
    {
        return $this->response->array([
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

    public function recaptcha(){
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
