<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController; // Asegúrate de tener este controlador
use Illuminate\Support\Facades\Route;

// =========================================================================
// RUTAS PROTEGIDAS (Requieren autenticación) - Vienen primero
// =========================================================================

Route::middleware('auth')->group(function () {
    // Dashboard: Punto de entrada a la gestión, apunta a la lista de cursos del usuario.
    Route::get('/dashboard', [CourseController::class, 'index'])->name('dashboard');

    // CRUD Resource para Cursos (Crea, Almacena, Edita, Actualiza, Elimina)
    // Usamos 'except' para evitar conflictos con la ruta pública 'showPublic'
    Route::resource('courses', CourseController::class)->except(['index', 'show']);

    // Rutas de reseñas
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Rutas de perfil de usuario (generadas por Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// =========================================================================
// RUTAS PÚBLICAS (SSR para SEO) - Vienen después de las específicas
// =========================================================================

// 1. Home Page: Muestra la lista de cursos destacados
Route::get('/', [CourseController::class, 'indexPublic'])->name('home'); 

// 2. Course Detail Page: Muestra el detalle del curso por slug (Esta es la ruta genérica)
Route::get('/courses/{course:slug}', [CourseController::class, 'showPublic'])->name('courses.show');


require __DIR__.'/auth.php';