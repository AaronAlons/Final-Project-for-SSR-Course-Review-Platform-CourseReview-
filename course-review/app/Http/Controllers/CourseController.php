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

    /**
     * Muestra la lista de cursos en el Dashboard para el usuario autenticado (R1).
     * Muestra TODOS los cursos si es admin/super_admin.
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdminForCourses()) {
            $courses = Course::with('user')->latest()->paginate(10);
            $platformData = [
                'title' => 'Administración Global de Cursos',
                'subtitle' => 'Estás viendo y gestionando TODOS los cursos de la plataforma.',
            ];
        } else {
            $courses = $user->courses()->latest()->paginate(10); 
            $platformData = [
                'title' => 'Mis Cursos Creados',
                'subtitle' => 'Gestiona aquí los cursos que has creado.',
            ];
        }

        return view('courses.index', compact('courses', 'platformData')); 
    }

    /**
     * Muestra la página de inicio pública (R7).
     */
    public function indexPublic(Request $request) 
    {
        // 1. Consulta base con rating y conteo de reseñas
        $query = Course::withAvg('reviews', 'rating')->withCount('reviews');

        // 2. Obtener los cursos destacados (featured) - Usamos clone para no afectar el query principal
        // El scope 'featured' filtra por aquellos con reviews_avg_rating = 5.
        $featuredCourses = (clone $query)->having('reviews_avg_rating', 5)->get();
        
        // 3. Obtener TODOS los cursos Paginados (excluyendo los destacados si queremos evitar duplicados)
        $courses = $query
                    ->whereNotIn('id', $featuredCourses->pluck('id')) // Excluir los destacados
                    ->latest()
                    ->paginate(12);

        $platformData = [
            'title' => 'Plataforma de Cursos Destacados',
            'subtitle' => 'Encuentra los cursos mejor reseñados por nuestra comunidad.',
        ];

        // 4. Pasar ambas colecciones a la vista
        return view('home', compact('courses', 'featuredCourses', 'platformData'));
    }


    /**
     * Muestra la vista pública de un curso específico.
     */
    public function showPublic(Course $course)
    {
        // Cargar las reseñas con el usuario y calcular el promedio de rating en el curso
        $course->load(['reviews.user'])
               ->loadAvg('reviews', 'rating')
               ->loadCount('reviews');

        // Determinar si el usuario ya reseñó (solo si está autenticado)
        $hasUserReviewed = false;
        if (Auth::check()) {
            $hasUserReviewed = $course->reviews->contains('user_id', Auth::id());
        }

        return view('courses.show', compact('course', 'hasUserReviewed'));
    }


    /**
     * Muestra el formulario para crear un nuevo curso (R2).
     */
    public function create()
    {
        $this->authorize('create', Course::class);
        $categories = ['Programacion', 'Lenguajes', 'Ofimatica', 'Diseño', 'Marketing', 'Hardware'];
        return view('courses.create', compact('categories'));
    }

    /**
     * Almacena un nuevo curso en la base de datos.
     */
    public function store(StoreCourseRequest $request)
    {
        $this->authorize('create', Course::class);
        $data = $request->validated();
        
        // LÓGICA DE SUBIDA DE IMAGEN
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('course_images', 'public');
            $data['image_url'] = $path;
        } else {
            // Si no se subió archivo, usamos el valor del input oculto image_url (si lo hubiera)
            $data['image_url'] = $data['image_url'] ?? null;
        }

        $data['user_id'] = Auth::id(); 
        $data['slug'] = Str::slug($data['title']);

        Course::create($data);

        return redirect()->route('dashboard')->with('success', 'Curso creado correctamente.');
    }

    /**
     * Esta ruta se omite en web.php (para evitar conflicto con la ruta pública courses.show).
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
        // Si no se envió 'image_file' ni 'image_url' en el request, se mantiene el valor actual de $course

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