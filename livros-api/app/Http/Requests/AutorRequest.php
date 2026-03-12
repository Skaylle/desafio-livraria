<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\RequestValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class AutorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:40',
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
            'nome.required' => 'O nome é obrigatória.',
            'nome.string' => 'O nome ser um texto válido.',
            'nome.max' => 'O nome ter mais que 40 caracteres.',
        ];
    }
}