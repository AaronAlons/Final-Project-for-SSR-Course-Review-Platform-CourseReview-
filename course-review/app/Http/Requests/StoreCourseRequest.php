<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta solicitud.
     */
    public function authorize(): bool
    {
        // Permitimos que cualquier usuario autenticado cree un curso
        return auth()->check(); 
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'unique:courses'],
            'description' => ['required', 'string'],
            'image_url' => ['nullable', 'url', 'max:255'],
            'category' => ['required', 'string', 'max:50'],
            'instructor' => ['required', 'string', 'max:255'],
            'modules_count' => ['required', 'integer', 'min:1'],
        ];
    }

    /**
     * Personaliza los mensajes de error para las reglas de validación.
     */
    public function messages(): array
    {
        return [
            'title.unique' => 'Ya existe un curso con este título. Por favor, elige uno diferente.',
            'image_url.url' => 'El campo URL de imagen debe ser una URL válida (empezar con http:// o https://).',
            'modules_count.min' => 'El curso debe tener al menos un módulo.',
        ];
    }
}