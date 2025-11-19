<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
  
    public function authorize(): bool
{
    // Ya está dentro del middleware 'auth', pero aseguramos que esté disponible.
    return auth()->check(); 
}

public function rules(): array
{
    return [
        'course_id' => ['required', 'exists:courses,id'], 
        
        'rating' => ['required', 'integer', 'min:1', 'max:5'],

        'content' => ['required', 'string', 'max:1000'],
    ];
}
}
