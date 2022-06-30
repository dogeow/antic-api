<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class Reset extends FormRequest
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
     */
    public function rules(Request $request): array
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
