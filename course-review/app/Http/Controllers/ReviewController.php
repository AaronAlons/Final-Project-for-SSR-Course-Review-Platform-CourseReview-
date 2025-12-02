<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreReviewRequest; // Importación necesaria
use App\Models\Review; // Importación necesaria

class ReviewController extends Controller
{
    /**
     * Guarda una nueva reseña en la base de datos.
     */
    public function store(StoreReviewRequest $request)
    {
        $data = $request->validated();
        
        // 2. Agregar el ID del usuario autenticado
        $data['user_id'] = auth()->id();
        
        // 3. Crear la reseña (ahora $data contiene todos los campos necesarios)
        Review::create($data); 
        
        // 4. Redireccionar
        return back()->with('success', '¡Reseña enviada con éxito!');
    }
}