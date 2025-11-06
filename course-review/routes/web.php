<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PublicCourseController; // <-- Ya lo tenías
use App\Http\Controllers\ReviewController; // <-- NUEVA LÍNEA

Route::get('/', [PublicCourseController::class, 'index'])->name('home');

// Vista de detalle del curso
Route::get('/curso/{course}', [PublicCourseController::class, 'show'])->name('courses.show'); 


// --- RUTAS DE AUTENTICACIÓN Y DASHBOARD (FASE 0) ---
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- RUTAS DE ADMIN (FASE 2) ---
    // Rutas para administrar cursos
    Route::resource('courses', CourseController::class)->except(['index', 'show']);

    // --- RUTA DE RESEÑAS (FASE 4) --- // <-- NUEVA SECCIÓN
    Route::post('/curso/{course}/reviews', [ReviewController::class, 'store']) // <-- NUEVA LÍNEA
          ->name('reviews.store'); // <-- NUEVA LÍNEA
});

require __DIR__.'/auth.php';