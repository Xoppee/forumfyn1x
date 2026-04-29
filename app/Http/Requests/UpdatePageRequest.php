<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $this->page?->id,
            'icon' => 'nullable|string|max:50',
            'content' => 'nullable|string',
            'is_published' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título é obrigatório.',
            'title.max' => 'O título não pode ter mais de 255 caracteres.',
            'slug.required' => 'O slug é obrigatório.',
            'slug.max' => 'O slug não pode ter mais de 255 caracteres.',
            'slug.unique' => 'Este slug já está em uso.',
            'icon.max' => 'O ícone não pode ter mais de 50 caracteres.',
            'is_published.boolean' => 'O campo publicado deve ser verdadeiro ou falso.',
        ];
    }
}