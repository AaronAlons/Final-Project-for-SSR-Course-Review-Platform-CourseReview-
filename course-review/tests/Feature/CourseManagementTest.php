<?php

use App\Models\Course; // <-- NUEVA LÍNEA
use App\Models\User; // <-- NUEVA LÍNEA
use Illuminate\Foundation\Testing\RefreshDatabase; // <-- NUEVA LÍNEA

// Esto reinicia la BD para cada prueba
uses(RefreshDatabase::class); // <-- NUEVA LÍNEA

/**
 * Prueba 3 (Seguridad)
 * Verifica que un invitado (guest) es redirigido al login
 * si intenta acceder a la página de creación de cursos.
 */
test('guest cannot access create course page', function () { // <-- NUEVA PRUEBA
    // 1. Act (Actuar)
    // Intentamos visitar la ruta protegida
    $response = $this->get('/courses/create');

    // 2. Assert (Verificar)
    // Verificamos que nos redirige a la página de login
    $response->assertRedirect('/login');
});

/**
 * Prueba 4 (Funcional)
 * Verifica que un usuario autenticado PUEDE crear un curso.
 */
test('authenticated user can create a course', function () { // <-- NUEVA PRUEBA
    // 1. Arrange (Preparar)
    // Creamos un usuario falso y nos logueamos como él
    $user = User::factory()->create();
    $this->actingAs($user);

    // Datos del curso que vamos a enviar
    $courseData = [
        'title' => 'Nuevo Curso de Pruebas',
        'description' => 'Descripción funcional.',
        'instructor' => 'Usuario de Prueba',
    ];

    // 2. Act (Actuar)
    // Hacemos un POST a la ruta 'courses.store'
    $response = $this->post(route('courses.store'), $courseData);

    // 3. Assert (Verificar)
    // Verificamos que nos redirige (al dashboard)
    $response->assertRedirect(route('dashboard'));

    // Verificamos que el curso existe en la base de datos
    $this->assertDatabaseHas('courses', [
        'title' => 'Nuevo Curso de Pruebas',
        'instructor' => 'Usuario de Prueba',
    ]);
});