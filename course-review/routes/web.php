<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// =================================================================
// RUTAS PÚBLICAS (SSR para SEO)
// =================================================================

// 1. Home Page: Muestra la lista de cursos destacados
Route::get('/', [CourseController::class, 'indexPublic'])->name('home'); 

// 2. Course Detail Page: Muestra el detalle del curso por slug
Route::get('/courses/{course:slug}', [CourseController::class, 'showPublic'])->name('courses.show');

// =================================================================
// RUTAS PROTEGIDAS (Requieren autenticación)
// =================================================================

Route::middleware('auth')->group(function () {
    // Dashboard: Punto de entrada a la gestión, apunta a la lista de cursos del usuario.
    Route::get('/dashboard', [CourseController::class, 'index'])->name('dashboard');
    
    // CRUD Resource para Cursos (Crea, Edita, Actualiza, Elimina)
    // Usamos 'except' porque 'index' y 'show' se manejan de forma personalizada arriba.
    Route::resource('courses', CourseController::class)->except(['index', 'show']);

    // Rutas de perfil de usuario (generadas por Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

require __DIR__.'/auth.php';