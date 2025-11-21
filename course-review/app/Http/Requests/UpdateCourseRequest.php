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
        // 🚨 REGLAS ACTUALIZADAS: Quitamos 'price' y añadimos 'image_url' y 'modules' 🚨
        return [
            'title' => ['required', 'string', 'max:255'],
            'instructor' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required', 'string', 'max:255'],
            'image_url' => ['nullable', 'url', 'max:255'], 
            'modules_count' => ['required', 'string'],
        ];
    }
}