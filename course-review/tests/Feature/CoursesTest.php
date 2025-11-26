<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

// Importaciones de funciones de PEST para hacerlo más limpio
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\actingAs;

// Usamos RefreshDatabase para asegurar que cada prueba corre en una base de datos limpia.
uses(RefreshDatabase::class);

// =================================================================
// 1. PRUEBAS PÚBLICAS
// =================================================================

/**
 * Prueba 1 (Pública): test_home_page_is_accessible()
 * Verifica un código 200 (OK) para la página principal.
 */
test('home page is accessible', function () {
    // 1. Ejecutar la petición GET a la ruta principal
    $response = get(route('home'));

    // 2. Verificar que el código de estado HTTP es 200 (OK)
    $response->assertStatus(200);
})->name('test_home_page_is_accessible');


/**
 * Prueba 2 (Pública): test_course_detail_page_displays_course_title()
 * Verifica que el título de un curso se muestre correctamente en su página de detalle.
 */
test('course detail page displays course title', function () {
    // 1. Crear un curso en la base de datos usando la Factory
    $course = Course::factory()->create([
        'title' => 'Curso de Pruebas de Software con PEST',
        // El slug se genera automáticamente si está configurado en el modelo/factory,
        // o si no, se puede forzar aquí:
        'slug' => Str::slug('Curso de Pruebas de Software con PEST'),
    ]);

    // 2. Ejecutar la petición GET a la ruta pública del curso (asumiendo 'courses.show_public')
    $response = get(route('courses.show_public', $course->slug));

    // 3. Verificar el código 200 (OK) y que el contenido de la página contiene el título del curso
    $response->assertStatus(200)
             ->assertSee($course->title);
})->name('test_course_detail_page_displays_course_title');


// =================================================================
// 2. PRUEBAS DE SEGURIDAD Y FUNCIONALIDAD AUTENTICADA
// =================================================================

/**
 * Prueba 3 (Seguridad): test_guest_cannot_access_create_course_page()
 * Verifica que un usuario no autenticado es redirigido a la página de login
 * al intentar acceder a una ruta protegida.
 */
test('guest cannot access create course page', function () {
    // 1. Ejecutar la petición GET a la página de creación de cursos
    $response = get(route('courses.create'));

    // 2. Verificar que la respuesta es una redirección a la página de login
    $response->assertRedirect(route('login'));
})->name('test_guest_cannot_access_create_course_page');


/**
 * Prueba 4 (Funcional): test_authenticated_user_can_create_a_course()
 * Simula el proceso completo de creación de un curso por un usuario logueado.
 */
test('authenticated user can create a course', function () {
    // 1. Preparar: Crear un usuario y simular el inicio de sesión
    $user = User::factory()->create();

    // 2. Preparar: Generar datos válidos para el nuevo curso
    // Los datos deben coincidir con las reglas de validación de StoreCourseRequest
    $courseData = [
        'title'         => 'Nuevo Curso Test Funcional',
        'instructor'    => $user->name,
        'description'   => 'Descripción detallada para la prueba de creación.',
        'category'      => 'Programacion',
        'modules_count' => 10,
        
    ];

    // 3. Actuar: Simular una petición POST a la ruta de almacenamiento de cursos
    $response = actingAs($user)->post(route('courses.store'), $courseData);

    // 4. Asertar: Verificar el flujo
    
    // 4a. Verificar que se redirige al dashboard tras la creación exitosa
    $response->assertRedirect(route('dashboard'));

    // 4b. Verificar que se adjunta un mensaje de éxito a la sesión
    $response->assertSessionHas('success', 'Curso creado correctamente.'); 

    // 4c. Verificar que el curso se guardó en la base de datos correctamente
    // Buscamos por el título y verificamos que esté asociado al usuario correcto.
    assertDatabaseHas('courses', [
        'title' => $courseData['title'],
        'user_id' => $user->id,
        'slug' => Str::slug($courseData['title']) // Verificar que el slug se haya generado
    ]);

})->name('test_authenticated_user_can_create_a_course');