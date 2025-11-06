<?php

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

// Esto reinicia la BD para cada prueba
uses(RefreshDatabase::class);

/**
 * Prueba de Seguridad (Reseñas)
 * Verifica que un invitado no puede enviar una reseña.
 */
test('guest cannot submit review', function () {
    // 1. Arrange (Preparar)
    // Creamos un curso al cual intentar enviar la reseña
    $course = Course::factory()->create();

    // 2. Act (Actuar)
    // Intentamos hacer POST a la ruta protegida
    $response = $this->post(route('reviews.store', $course), [
        'rating' => 5,
        'comment' => 'Esto no debería funcionar',
    ]);

    // 3. Assert (Verificar)
    // Verificamos que nos redirige a la página de login
    $response->assertRedirect('/login');
});

/**
 * Prueba Funcional (Reseñas)
 * Verifica que un usuario autenticado PUEDE enviar una reseña.
 */
test('authenticated user can submit review', function () {
    // 1. Arrange (Preparar)
    $user = User::factory()->create();
    $course = Course::factory()->create();

    // Datos de la reseña
    $reviewData = [
        'rating' => 5,
        'comment' => '¡Excelente curso!',
    ];

    // 2. Act (Actuar)
    // Nos logueamos y enviamos el formulario
    $response = $this->actingAs($user)
                     ->post(route('reviews.store', $course), $reviewData);

    // 3. Assert (Verificar)
    // Verificamos que nos redirige de vuelta (a la pág. del curso)
    $response->assertRedirect(); // 'back()' es solo assertRedirect()

    // Verificamos que la reseña existe en la BD
    $this->assertDatabaseHas('reviews', [
        'course_id' => $course->id,
        'user_id' => $user->id,
        'rating' => 5,
        'comment' => '¡Excelente curso!',
    ]);
});