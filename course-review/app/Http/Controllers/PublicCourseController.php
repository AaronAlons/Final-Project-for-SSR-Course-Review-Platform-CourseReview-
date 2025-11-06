<?php

namespace App\HttpControllers;

use Illuminate\Http\Request;
use App\Models\Course; // <-- NUEVA LÍNEA

class PublicCourseController extends Controller
{
    /**
     * Muestra la página de inicio con la lista de cursos paginados.
     */
    public function index() // <-- NUEVO MÉTODO
    {
        // Obtenemos los cursos (paginados)
        $courses = Course::latest()->paginate(10);

        // Renderizamos la vista Blade y le pasamos los datos
        return view('home', ['courses' => $courses]);
    }

    /**
     * Muestra la vista de detalle de un curso específico.
     */
    public function show(Course $course) // <-- NUEVO MÉTODO
    {
        // Cargamos el curso y sus reseñas (Eager Loading para optimizar queries)
        // Esto previene el problema N+1
        $course->load('reviews.user');

        // Renderizamos la vista de detalle
        return view('courses.show', ['course' => $course]);
    }
}