<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
{
    // Ya está dentro del middleware 'auth', pero aseguramos que esté disponible.
    return auth()->check(); 
}

public function rules(): array
{
    return [
        'course_id' => 'required|exists:courses,id', // ID del curso al que pertenece la reseña
        'rating' => 'required|integer|min:1|max:5',  // Calificación de 1 a 5
        'comment' => 'required|string|max:1000',
    ];
}
}
