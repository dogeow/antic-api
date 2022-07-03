<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagAdd extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                //                Rule::unique('post_tags', 'name')->where(function ($query) {
                //                    return $query->where('post_id', $this->route('post')->id);
                //                }),
            ],
        ];
    }
}
