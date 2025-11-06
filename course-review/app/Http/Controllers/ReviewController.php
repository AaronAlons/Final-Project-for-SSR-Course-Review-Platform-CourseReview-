<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\StoreReviewRequest; // <-- NUEVA LÍNEA
use App\Models\Course; // <-- NUEVA LÍNEA

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReviewRequest  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreReviewRequest $request, Course $course) // <-- NUEVO MÉTODO
    {
        // La validación ya pasó gracias a StoreReviewRequest
        
        // Obtenemos los datos validados (rating y comment)
        $validatedData = $request->validated();
        
        // Añadimos el ID del usuario autenticado 
        $validatedData['user_id'] = auth()->id();
        
        // Creamos la reseña asociada directamente al curso 
        $course->reviews()->create($validatedData);

        // Redirigimos de vuelta a la página del curso [cite: 140]
        return back()->with('success', '¡Reseña enviada exitosamente!');
    }
}