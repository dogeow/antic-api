<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser(Request $request): User
    {
        // 创建用户
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 头像上传并更新用户
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar')->store('avatars');
            $user->update(['avatar' => $avatar]);
        }

        return $user;
    }
}
