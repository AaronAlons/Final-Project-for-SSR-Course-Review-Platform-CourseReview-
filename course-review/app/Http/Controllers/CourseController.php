<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest; 
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Auth;
// 🔥 NUEVAS IMPORTACIONES: Para manejar la subida de archivos
use Illuminate\Support\Facades\Storage;
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
    public function indexPublic(Request $request) // Añadimos Request para paginación
    {
        // 1. Obtener TODOS los cursos Paginados, cargando el promedio de rating
        $courses = Course::withAvg('reviews', 'rating')
                         ->withCount('reviews') // Para obtener reviews_count
                         ->latest()
                         ->paginate(12); // Paginación para la sección principal.

        // 2. Obtener los cursos destacados (featured) del set paginado
        // Nota: El featured scope actúa sobre el rating promedio (reviews_avg_rating)
        // para encontrar los cursos con 5 estrellas.
        $featuredCourses = $courses->filter(function ($course) {
            // Filtramos los cursos con rating promedio de 5
            return $course->reviews_avg_rating == 5;
        });

        // 3. Preparar la información de la plataforma
        $platformData = [
            'title' => 'Cursos y Reseñas',
            'subtitle' => 'Descubre, aprende y comparte tu opinión sobre los mejores cursos.',
        ];
        
        // 4. Se usa la vista de home, enviando los cursos paginados y los destacados.
        // Ahora usamos $courses para la paginación principal.
        return view('home', compact('featuredCourses', 'courses', 'platformData'));
    }
    
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
        
        // 🔥 LÓGICA DE SUBIDA DE IMAGEN
        if ($request->hasFile('image_file')) {
            // Guarda la imagen en storage/app/public/course_images
            // y devuelve la ruta relativa (ej: 'course_images/archivo_hash.jpg')
            $path = $request->file('image_file')->store('course_images', 'public');
            $data['image_url'] = $path;
        } else {
            // Si no hay archivo, aseguramos que el campo esté vacío.
            $data['image_url'] = null;
        }

        $data['user_id'] = auth()->id(); // Asigna el ID del usuario actual
        $data['slug'] = Str::slug($data['title']); // Genera el slug

        Course::create($data);

        return redirect()->route('dashboard')->with('success', 'Curso creado correctamente.');
    }

    /**
     * Muestra el detalle de un curso público (R8).
     */
    public function showPublic(Course $course)
    {
        // Carga las reseñas y el usuario de cada reseña.
        $course->load(['reviews.user']); 
        
        // Carga el promedio de rating y el conteo de reseñas para mostrar en la vista
        $course = $course->loadAvg('reviews', 'rating')->loadCount('reviews');

        return view('courses.show', compact('course'));
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
        
        // 🔥 LÓGICA DE ACTUALIZACIÓN DE IMAGEN
        if ($request->hasFile('image_file')) {
            // 1. Eliminar la imagen anterior si existe
            if ($course->image_url) {
                Storage::disk('public')->delete($course->image_url);
            }
            
            // 2. Subir la nueva imagen
            $path = $request->file('image_file')->store('course_images', 'public');
            $data['image_url'] = $path;
        } 
        // Si no se sube un nuevo archivo, mantenemos la imagen_url existente en $course
        // o si el usuario quiere eliminarla, podría haber un campo adicional, pero por ahora la mantenemos.
        // Si no se envió 'image_file', simplemente no modificamos $data['image_url'] 
        // y se usará el valor que ya tenía el curso.

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
        
        // 🔥 LÓGICA DE ELIMINACIÓN DE IMAGEN
        if ($course->image_url) {
            Storage::disk('public')->delete($course->image_url);
        }
        
        $course->delete();
        return redirect()->route('dashboard')->with('success', 'Curso eliminado correctamente.');
    }
}