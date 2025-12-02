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
        // Esta migración solo debe agregar las columnas que faltan
        // asumiendo que 'description' e 'image_url' ya fueron creadas
        // en '2025_11_05_051236_create_courses_table.php'.
        Schema::table('courses', function (Blueprint $table) {
            
            // Agrega 'category' después de 'image_url'. 
            // Esto solo funcionará si 'image_url' existe en la tabla.
            $table->string('category')->after('image_url')->nullable(); 
            
            // Agrega 'modules_count'
            $table->unsignedInteger('modules_count')->default(1)->after('category'); 
            
            // Opcional: Agregar un campo booleano si tienes cursos destacados
            // $table->boolean('is_featured')->default(false)->after('modules_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // El método down debe eliminar SÓLO las columnas que agregó up().
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['category', 'modules_count']);
            // Si agregaste 'is_featured', también debes eliminarla aquí:
            // $table->dropColumn('is_featured');
        });
    }
};