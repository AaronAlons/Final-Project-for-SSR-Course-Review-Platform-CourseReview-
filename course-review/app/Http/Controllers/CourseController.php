<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest; 
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Auth; // <-- ¡Aseguramos esta importación!

class CourseController extends Controller
{
    // === MÉTODOS DE LISTADO Y HOME ===

    /**
     * Muestra la lista de cursos en el Dashboard para el usuario autenticado (R1).
     */
    public function index()
    {
        // Obtiene solo los cursos creados por el usuario autenticado.
        $courses = auth()->user()->courses()->latest()->paginate(10); 

        $platformData = [
            'title' => 'Mis Cursos Creados',
            'subtitle' => 'Gestiona aquí los cursos que has creado.',
        ];

        // *** CAMBIO CLAVE ***: Usa la vista de gestión
        return view('courses.index', compact('courses', 'platformData')); 
        // Asegúrate de que tienes un archivo resources/views/courses/index.blade.php
    }

    /**
     * Muestra la página de inicio pública (R7).
     * Asegura que las tres variables (featuredCourses, courses, platformData) existan.
     */
    public function indexPublic()
    {
        // 1. Preparar la consulta base con el promedio de rating
        // (Esto ya asume que la tabla 'reviews' existe después del migrate:fresh)
        $query = Course::withAvg('reviews', 'rating');

        // 2. Obtener los cursos destacados (featured)
        // Usamos una consulta independiente para asegurar que featuredCourses siempre se defina.
        $featuredCourses = Course::withAvg('reviews', 'rating')->featured()->get();
        
        // 3. Obtener el resto de los cursos, excluyendo los IDs destacados.
        $allCourses = Course::withAvg('reviews', 'rating')
                            ->whereNotIn('id', $featuredCourses->pluck('id'))
                            ->latest()
                            ->get();

        // 4. Definir la data estática para la vista
        $platformData = [
            'title' => 'Plataforma de Reseñas de Cursos',
            'subtitle' => 'Encuentra tu próximo curso y deja tu opinión sincera.',
        ];

        return view('home', [
            'featuredCourses' => $featuredCourses, 
            'courses' => $allCourses,             
            'platformData' => $platformData,  
        ]);
    }

    // === MÉTODOS DEL CRUD DE CURSOS (PROTEGIDOS) ===
    
    public function create()
    {
        $categories = ['Programacion', 'Lenguajes', 'Ofimatica', 'Diseño', 'Marketing', 'Hardware'];
        return view('courses.create', compact('categories'));
    }

    public function store(StoreCourseRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($data['title']);

        Course::create($data);

        return redirect()->route('dashboard')->with('success', 'Curso creado con éxito.');
    }

    public function showPublic(Course $course)
    {
        $reviews = $course->reviews()->with('user')->latest()->get(); 
        return view('courses.show', compact('course', 'reviews'));
    }

    public function show(Course $course) 
    { 
        abort(404); 
    }

    public function edit(Course $course)
    {
        $categories = ['Programacion', 'Lenguajes', 'Ofimatica', 'Diseño', 'Marketing', 'Hardware'];
        return view('courses.edit', compact('course', 'categories'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);
        $course->update($data); 
        return redirect()->route('dashboard')->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('dashboard')->with('success', 'Curso eliminado correctamente.');
    }
}