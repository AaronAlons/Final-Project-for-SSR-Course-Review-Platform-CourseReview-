<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReviewController; // Asegúrate de tener esta importación

// =========================================================================
// RUTAS PÚBLICAS (Home)
// =========================================================================

// Ruta principal
Route::get('/', [CourseController::class, 'indexPublic'])->name('home');

// *** RUTAS PÚBLICAS DE DETALLE DE CURSO Y RESEÑAS ***
// Ruta para ver los detalles de un curso (usando el slug)
// ESTA ES LA RUTA CRÍTICA
Route::get('/cursos/{course:slug}', [CourseController::class, 'showPublic'])->name('courses.show_public');

// Ruta para guardar una nueva reseña
Route::post('/cursos/{course:slug}/reviews', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');

// =========================================================================
// RUTAS AUTENTICADAS (Dashboard)
// =========================================================================

Route::middleware('auth')->group(function () {
    // Ruta principal del dashboard (lista de mis cursos)
    Route::get('/dashboard', [CourseController::class, 'index'])->name('dashboard');

    // Rutas RESTful para la gestión de cursos (CRUD)
    Route::resource('courses', CourseController::class)->except([
        'show' // Excluimos 'show' para no chocar con la ruta pública courses.show_public
    ]);
    
    // Rutas de Perfil (Profile)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';