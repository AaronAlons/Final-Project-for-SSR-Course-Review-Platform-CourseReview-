<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request)
    {
        $validated = $request->validated();
        
        // Verificar si el usuario ya ha reseñado este curso (opcional, pero buena práctica)
        $existingReview = Review::where('user_id', auth()->id())
                                ->where('course_id', $validated['course_id'])
                                ->exists();
        
        if ($existingReview) {
             return back()->withErrors(['review_error' => 'Ya has dejado una reseña para este curso.'])->withInput();
        }

        // Crear la reseña
        Review::create([
            'user_id' => auth()->id(),
            'course_id' => $validated['course_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        // Redirigir de vuelta a la página de detalle del curso (usando el ID para simplificar)
        // Nota: Idealmente, redirigiríamos usando el slug. Buscamos el curso:
        $course = \App\Models\Course::find($validated['course_id']); 

        return redirect()->route('courses.show', $course->slug)
            ->with('success', '¡Gracias! Tu reseña ha sido enviada.');
    }
}