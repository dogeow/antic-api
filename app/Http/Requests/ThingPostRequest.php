<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThingPostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'photos' => 'required|array',
            'tags' => 'required|array',
            'description' => 'nullable|string',
            'amount' => 'nullable|integer',
            'money' => 'nullable|regex:/^\d*(\.\d{2})?$/',
            'bought_at' => 'nullable|date',
            'expired_at' => 'nullable|date',
            'is_expiration_reminder' => 'nullable|boolean',
        ];
    }
}
