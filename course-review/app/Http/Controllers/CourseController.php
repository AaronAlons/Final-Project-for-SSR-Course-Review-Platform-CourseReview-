<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest; 
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Auth;

// *** IMPORTACIÓN CLAVE QUE FALTABA ***
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CourseController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        
        $courses = auth()->user()->courses()->latest()->paginate(10); 

        $platformData = [
            'title' => 'Mis Cursos Creados',
            'subtitle' => 'Gestiona aquí los cursos que has creado.',
        ];

        // Se usa la vista de gestión donde mostramos la tabla.
        return view('courses.index', compact('courses', 'platformData')); 
    }

    /**
     * Muestra la página de inicio pública (R7).
     */
    public function indexPublic()
    {
        // 1. Preparar la consulta base con el promedio de rating
        $query = Course::withAvg('reviews', 'rating');

        // 2. Obtener los cursos destacados (featured)
        // Usamos una consulta independiente para asegurar que featuredCourses siempre se defina.
        $featuredCourses = Course::withAvg('reviews', 'rating')->featured()->get();
        
        // 3. Obtener el resto de cursos, excluyendo los destacados
        // Usamos whereNotIn para evitar duplicados si un curso cumple ambas condiciones
        $allCourses = Course::withAvg('reviews', 'rating')
                            ->whereNotIn('id', $featuredCourses->pluck('id'))
                            ->latest()
                            ->get();

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

    /**
     * Muestra la página pública de un curso.
     */
    public function showPublic(Course $course)
    {
        // Carga las reseñas relacionadas con el curso y su usuario para mostrar
        $reviews = $course->reviews()->with('user')->latest()->get(); 
        return view('courses.show', compact('course', 'reviews'));
    }

    /**
     * Método show vacío (para evitar conflicto con la ruta pública courses.show).
     */
    public function show(Course $course) 
    { 
        // Esta ruta no debe ser accesible o se redirige. Usamos 404 por defecto.
        abort(404); 
    }

    /**
     * Muestra el formulario para editar un curso existente.
     */
    public function edit(Course $course)
    {
        // Autorización: ahora el método authorize() funcionará gracias al trait.
        $this->authorize('update', $course);
        $categories = ['Programacion', 'Lenguajes', 'Ofimatica', 'Diseño', 'Marketing', 'Hardware'];
        return view('courses.edit', compact('course', 'categories'));
    }

    /**
     * Actualiza un curso en la base de datos.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        // Autorización: ahora el método authorize() funcionará.
        $this->authorize('update', $course); 
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);
        $course->update($data); 
        return redirect()->route('dashboard')->with('success', 'Curso actualizado correctamente.');
    }

    /**
     * Elimina un curso de la base de datos.
     */
    public function destroy(Course $course)
    {
        // Autorización: ahora el método authorize() funcionará.
        $this->authorize('delete', $course); 
        
        $course->delete();
        return redirect()->route('dashboard')->with('success', 'Curso eliminado correctamente.');
    }
}