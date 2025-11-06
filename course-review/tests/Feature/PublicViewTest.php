<?php

use App\Models\Course; // <-- NUEVA LÍNEA
use Illuminate\Foundation\Testing\RefreshDatabase; // <-- NUEVA LÍNEA

// Esto reinicia la BD para cada prueba
uses(RefreshDatabase::class); // <-- NUEVA LÍNEA

/**
 * Prueba 1 (Renombrada)
 * Verifica que la página de inicio carga correctamente.
 */
test('home page loads successfully', function () { // <-- NOMBRE CAMBIADO
    $response = $this->get('/');

    $response->assertStatus(200);
});

/**
 * Prueba 2
 * Verifica que un curso creado aparece en la vista de inicio.
 */
test('home page displays courses', function () { // <-- NUEVA PRUEBA
    // 1. Arrange (Preparar)
    // Creamos un curso falso en la BD de prueba
    $course = Course::factory()->create([
        'title' => 'Curso de Prueba de PEST',
        'description' => 'Descripción de prueba'
    ]);

    // 2. Act (Actuar)
    // Visitamos la página de inicio
    $response = $this->get('/');

    // 3. Assert (Verificar)
    // Verificamos que se ve el título y la descripción
    $response->assertStatus(200);
    $response->assertSee($course->title);
    $response->assertSee(Str::limit($course->description, 100)); // Verificamos la descripción corta
});


/**
 * Prueba 3
 * Verifica que la página de detalle del curso carga.
 */
test('course detail page loads', function () { // <-- NUEVA PRUEBA
    // 1. Arrange (Preparar)
    $course = Course::factory()->create();

    // 2. Act (Actuar)
    // Visitamos la página de detalle usando el slug del curso
    $response = $this->get('/curso/' . $course->slug);

    // 3. Assert (Verificar)
    $response->assertStatus(200);
    $response->assertSee($course->title);
    $response->assertSee($course->instructor);
});