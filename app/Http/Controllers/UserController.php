<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function password()
    {
        $payload = request(['currPassword', 'newPassword', 'passwordConfirmation']);

        // 验证格式
        $rules = [
            'currPassword' => ['required', 'min:8', 'max:16'],
            'newPassword' => ['required', 'min:8', 'max:16', 'different:currPassword'],
            'passwordConfirmation' => ['same:password'],
        ];
        $validator = Validator::make($payload, $rules);
        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }

        $user = auth()->user();
        if ($user->password === bcrypt($payload['currPassword'])) {
            $user->password = bcrypt($payload['password']);
        } else {
            return 401;
        }
    }
}
