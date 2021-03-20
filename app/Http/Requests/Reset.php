<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\Account;

class Reset extends FormRequest
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
     * @param  Request  $request
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'password' => [
                'required', 'not_regex:/\s+/', 'min:8', 'max:16',
            ],
            'password_confirmation' => [
                'nullable', 'same:password',
            ],
        ];
    }
}
