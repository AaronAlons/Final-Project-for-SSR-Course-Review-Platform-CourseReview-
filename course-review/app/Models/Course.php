<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Asegúrate de tener esta importación si usas factories

class Course extends Model
{
    use HasFactory;
    
    // CAMPOS QUE PUEDEN SER ASIGNADOS MASIVAMENTE
    protected $fillable = [
        'title', 
        'slug', 
        'instructor',
        'description', 
        'instructor', 
        'category', 
        'user_id'
    ];

    // RELACIÓN: Un curso tiene muchas reseñas
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    // RELACIÓN: Un curso pertenece a un usuario (creador)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Para usar el 'slug' en la URL en lugar del ID (Route Model Binding)
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // =========================================================================
    // SCOPES (MÉTODOS DE CONSULTA)
    // =========================================================================

    /**
     * Scope para obtener cursos destacados.
     * En este caso, destacaremos los cursos con un promedio de 5 estrellas.
     * El withAvg('reviews', 'rating') debe ejecutarse ANTES de llamar este scope.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        // El campo 'reviews_avg_rating' es creado por withAvg en el controlador.
        // Aquí filtramos por aquellos cuyo promedio es 5.
        return $query->having('reviews_avg_rating', 5);
        
        // O si quieres algo más simple (e.g., aquellos con más de 10 reseñas)
        // return $query->where('review_count', '>', 10);
    }
}