<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\RequestValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class LivroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:40',
            'editora' => 'required|string|max:40',
            'edicao' => 'required|integer|min:1',
            'ano_publicacao' => 'required|digits:4',
            'valor' => 'required|numeric|min:0',

            // 'autores' => 'required|array',
            // 'autores.*' => 'exists:autors,cod_autor',

            // 'assuntos' => 'required|array',
            // 'assuntos.*' => 'exists:assuntos,cod_assunto',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => $validator->errors()

            ])
        );
    }

    public function messages()
    {
        return [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.string' => 'O título deve ser um texto válido.',
            'titulo.max' => 'O título não pode ter mais que 40 caracteres.',

            'editora.required' => 'A editora é obrigatória.',
            'editora.string' => 'A editora deve ser um texto válido.',
            'editora.max' => 'A editora não pode ter mais que 40 caracteres.',

            'edicao.required' => 'A edição é obrigatória.',
            'edicao.integer' => 'A edição deve ser um número inteiro.',
            'edicao.min' => 'A edição deve ser maior que 0.',

            'ano_publicacao.required' => 'O ano de publicação é obrigatório.',
            'ano_publicacao.digits' => 'O ano de publicação deve ter exatamente 4 dígitos.',

            'valor.required' => 'O valor é obrigatório.',
            'valor.numeric' => 'O valor deve ser numérico.',
            'valor.min' => 'O valor não pode ser negativo.',
        ];
    }
}