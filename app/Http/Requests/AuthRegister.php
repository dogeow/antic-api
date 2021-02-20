<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegister extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return  [
            'name' => [
                'required', 'not_regex:/\s+/', function ($attribute, $value, $fail) {
                    if (mb_strwidth($value) < 4 || mb_strwidth($value) > 16) {
                        $fail('昵称 宽度必须在 4 - 16 之间（一个中文文字为 2 个宽度）');
                    }
                },
            ],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'not_regex:/\s+/', 'min:8', 'max:16'],
            'password_confirmation' => ['same:password'],
        ];
    }
}
