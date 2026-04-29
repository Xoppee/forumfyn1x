<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'body' => 'required|string|max:10000',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'body.required' => 'O conteúdo é obrigatório.',
            'body.max' => 'O conteúdo não pode ter mais de 10000 caracteres.',
            'images.*.image' => 'O arquivo deve ser uma imagem.',
            'images.*.max' => 'A imagem não pode ter mais de 2MB.',
        ];
    }
}