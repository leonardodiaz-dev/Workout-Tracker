<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreEjercicioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100|unique:ejercicios',
            'descripcion' => 'required|string',
            'categoria_id' => 'required|integer|exists:categorias,id',
            'grupo_muscular_id' => 'required|integer|exists:grupos_musculares,id'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
          throw new HttpResponseException(response()->json([
            'message' => 'Datos inválidos.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
