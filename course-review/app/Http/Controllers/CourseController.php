<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Obtiene solo los cursos creados por el usuario autenticado.
    // Usamos el método 'user()' para obtener la instancia del usuario actual.
    $courses = auth()->user()->courses()->latest()->paginate(10); 
    
    // Si queremos que un administrador vea todos los cursos, la lógica es diferente:
    /*
    if (auth()->user()->id === 1) { // Lógica simple de administrador
        $courses = Course::latest()->paginate(10);
    } else {
        $courses = auth()->user()->courses()->latest()->paginate(10);
    }
    */
    
    return view('courses.index', compact('courses'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        // Retorna la vista con el objeto Course para prellenar el formulario
    return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course) // [cite: 97]
    {
    // Los datos ya están validados por UpdateCourseRequest
    $course->update($request->validated()); 
    return redirect()->route('dashboard')->with('success', 'Curso actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
    $course->delete(); // Elimina el registro
    return redirect()->route('dashboard')->with('success', 'Curso eliminado correctamente.'); // Redirecciona a donde liste los cursos
    }

    public function indexPublic()
{
    // Carga los cursos más recientes para la página de inicio
    // Solo mostramos 6 cursos o los que se definan para el "Home"
    $courses = Course::latest()->take(6)->get(); 
    
    // Aquí puedes definir datos estáticos de la plataforma
    $platformData = [
        'title' => 'Plataforma de Reseñas de Cursos',
        'subtitle' => 'Encuentra tu próximo curso y deja tu opinión sincera.',
    ];
    
    return view('home', compact('courses', 'platformData'));
}

public function showPublic(Course $course) // Course $course ya está cargado por el slug
{
    // Cargar las reseñas relacionadas al curso para mostrarlas.
    // También precargamos el usuario que hizo la reseña (user) para evitar el problema N+1.
    $reviews = $course->reviews()->with('user')->latest()->get(); 

    // También necesitamos el promedio de calificación (si ya implementaste el atributo)
    // $averageRating = $course->average_rating; 

    return view('courses.show', compact('course', 'reviews'));
}
}
