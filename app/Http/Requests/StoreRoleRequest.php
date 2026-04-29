<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles,slug',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|max:100',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'slug.required' => 'O slug é obrigatório.',
            'slug.max' => 'O slug não pode ter mais de 255 caracteres.',
            'slug.unique' => 'Este slug já está em uso.',
            'icon.max' => 'O ícone não pode ter mais de 50 caracteres.',
            'color.max' => 'A cor não pode ter mais de 50 caracteres.',
            'permissions.array' => 'As permissões deve ser um array.',
            'user_ids.array' => 'Os usuários deve ser um array.',
            'user_ids.*.exists' => 'Um dos usuários selecionados não existe.',
        ];
    }
}