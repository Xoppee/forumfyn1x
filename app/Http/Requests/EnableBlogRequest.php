<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnableBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'description.max' => 'A descrição não pode ter mais de 1000 caracteres.',
        ];
    }
}
