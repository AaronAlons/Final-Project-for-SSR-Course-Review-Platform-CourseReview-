<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        $title = $this->faker->sentence(3);
        
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'instructor' => $this->faker->name,
            'description' => $this->faker->paragraph(3),
            'category' => $this->faker->randomElement(['Programacion', 'Lenguajes', 'Ofimatica', 'Diseño', 'Marketing', 'Hardware']),
            'user_id' => User::factory(),
            'image_url' => $this->faker->imageUrl(640, 480, 'education', true),
            'modules_count' => $this->faker->numberBetween(1, 10),
        ];
    }
}