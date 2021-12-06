<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\Account;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class Forget extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request): array
    {
        return [
            'account' => [
                'required',
                new Account(),
            ],
        ];
    }
}
