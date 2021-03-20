<?php

namespace App\Http\Requests;

use App\Rules\Account;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class Forget extends FormRequest
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
            'account' => [
                'required',
                new Account,
            ],
        ];
    }
}
