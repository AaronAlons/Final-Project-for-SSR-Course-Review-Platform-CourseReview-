<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest; 
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // === MÉTODOS DE LISTADO Y HOME ===

    /**
     * Muestra la lista de cursos en el Dashboard para el usuario autenticado (R1).
     */
    public function index()
    {
        // Obtiene solo los cursos creados por el usuario autenticado.
        // Asume que la relación 'courses()' está definida en el modelo User.
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
    
    /**
     * Muestra el formulario para crear un nuevo curso.
     */
    public function create()
    {
        $categories = ['Programacion', 'Lenguajes', 'Ofimatica', 'Diseño', 'Marketing', 'Hardware'];
        return view('courses.create', compact('categories'));
    }

    /**
     * Almacena un nuevo curso en la base de datos.
     */
    public function store(StoreCourseRequest $request)
    {
        $data = $request->validated();
        
        // ASIGNACIÓN CLAVE: Asigna el ID del usuario autenticado al curso.
        $data['user_id'] = auth()->id(); 
        
        $data['slug'] = Str::slug($data['title']);

        Course::create($data);

        return redirect()->route('dashboard')->with('success', 'Curso creado con éxito.');
    }

    /**
     * Muestra la vista pública del detalle del curso (con reseñas).
     */
    public function showPublic(Course $course)
    {
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
        // Aquí puedes añadir una verificación de política (ej: $this->authorize('update', $course);)
        $categories = ['Programacion', 'Lenguajes', 'Ofimatica', 'Diseño', 'Marketing', 'Hardware'];
        return view('courses.edit', compact('course', 'categories'));
    }

    /**
     * Actualiza un curso en la base de datos.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        // Aquí puedes añadir una verificación de política.
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
        // Aquí puedes añadir una verificación de política.
        $course->delete();
        return redirect()->route('dashboard')->with('success', 'Curso eliminado correctamente.');
    }
}