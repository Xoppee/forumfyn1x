<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user()?->id;
        
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($userId)],
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|max:2048',
            'cover' => 'nullable|image|max:4096',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email deve ser um endereço válido.',
            'email.unique' => 'Este email já está em uso.',
            'bio.max' => 'A bio não pode ter mais de 1000 caracteres.',
            'avatar.image' => 'O avatar deve ser uma imagem.',
            'avatar.max' => 'O avatar não pode ter mais de 2MB.',
            'cover.image' => 'A capa deve ser uma imagem.',
            'cover.max' => 'A capa não pode ter mais de 4MB.',
        ];
    }
}