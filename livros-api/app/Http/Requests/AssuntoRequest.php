<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AssuntoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'descricao' => 'required|string|max:20',
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
            'descricao.required' => 'O assunto é obrigatória.',
            'descricao.string' => 'O assunto ser um texto válido.',
            'descricao.max' => 'O assunto ter mais que 40 caracteres.',
        ];
    }
}