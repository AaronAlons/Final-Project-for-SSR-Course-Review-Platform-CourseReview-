<?php

namespace App\Http\Requests; // <-- Corrigiendo el namespace

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // <-- LÍNEA MODIFICADA (de false a true)
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // <-- SECCIÓN MODIFICADA
        return [
            'rating' => 'required|integer|min:1|max:5', // Reglas para calificación
            'comment' => 'required|string', // Reglas para comentario
        ];
    }
}