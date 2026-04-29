<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role_id' => 'required|exists:roles,id',
        ];
    }

    public function messages(): array
    {
        return [
            'role_id.required' => 'O cargo é obrigatório.',
            'role_id.exists' => 'O cargo selecionado não existe.',
        ];
    }
}