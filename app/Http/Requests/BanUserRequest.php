<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BanUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'is_banned' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'is_banned.required' => 'O campo banir é obrigatório.',
            'is_banned.boolean' => 'O valor deve ser verdadeiro ou falso.',
        ];
    }
}