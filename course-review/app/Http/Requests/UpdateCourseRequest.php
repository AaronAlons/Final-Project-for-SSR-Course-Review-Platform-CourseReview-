<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // La autorización se maneja en el controlador (o policy), 
        // pero aquí confirmamos que el usuario está logueado.
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'instructor' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required', 'string', 'max:255'],

            // 🔥 REGLA DE ARCHIVO DE IMAGEN:
            // Debe ser un archivo, opcional, tipo imagen, y con un tamaño máximo de 2MB.
            'image_file' => ['nullable', 'image', 'max:2048'], 

            // Dejamos image_url como está, pero la usaremos solo para mostrar la ruta en el controlador
            'image_url' => ['nullable', 'string', 'max:255'], 
            
            'modules_count' => ['required', 'integer', 'min:1'],
        ];
    }
}