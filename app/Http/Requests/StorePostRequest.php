<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'topic_id' => 'required|exists:topics,id',
            'body' => 'required|string|max:10000',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'topic_id.required' => 'O tópico é obrigatório.',
            'topic_id.exists' => 'O tópico selecionado não existe.',
            'body.required' => 'O conteúdo é obrigatório.',
            'body.max' => 'O conteúdo não pode ter mais de 10000 caracteres.',
            'images.*.image' => 'O arquivo deve ser uma imagem.',
            'images.*.max' => 'A imagem não pode ter mais de 2MB.',
        ];
    }
}