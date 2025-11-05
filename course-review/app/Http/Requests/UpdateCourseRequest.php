<?php

namespace App\HttpC\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str; // <-- NUEVA LÍNEA

class UpdateCourseRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructor' => 'required|string|max:255',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void // <-- NUEVO MÉTODO
    {
        $this->merge([
            'slug' => Str::slug($this->title),
        ]);
    }
}