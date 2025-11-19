<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // El creador del curso (instructor)
            $table->string('title');
            $table->string('slug')->unique(); // Columna esencial para las rutas
            $table->string('instructor');
            // Las columnas que faltaban o estaban en el lugar equivocado
            $table->text('description'); 
            $table->string('image_url')->nullable(); // ¡Esta es la que faltaba!
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};