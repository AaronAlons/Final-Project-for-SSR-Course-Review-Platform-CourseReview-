<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; // <-- NUEVA LÍNEA

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // <-- SECCIÓN MODIFICADA
        $title = $this->faker->sentence(4); // Genera un título falso

        return [
            'title' => $title,
            'slug' => Str::slug($title), // Genera un slug basado en el título
            'description' => $this->faker->paragraph(3),
            'instructor' => $this->faker->name(),
        ];
    }
}