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
        return false; //hace que si no esta autenticado no pueda editar
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    // Usamos $this->route('course') para obtener el objeto Course
    $courseId = $this->route('course') ? $this->route('course')->id : null; 
    
    return [
        // title, description, instructor: Requeridos
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'instructor' => 'required|string|max:255',
        
        // slug: Requerido, único, e ignora el slug del curso actual ($courseId)
        'slug' => [ 
            'required',
            'string',
            'max:255',
            'unique:courses,slug,' . $courseId, // [cite: 34]
        ],
    ];
}
}