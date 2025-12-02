<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use App\Models\Review; // Asegúrate de importar Review
use App\Models\User;   // Asegúrate de importar User

class Course extends Model
{
    use HasFactory;
    
    // CAMPOS QUE PUEDEN SER ASIGNADOS MASIVAMENTE
    protected $fillable = [
        'title', 
        'slug', 
        'instructor',
        'description', 
        'category', 
        'user_id',
        'image_url',
        'modules_count'
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
     */
    public function scopeFeatured($query)
{
    // Este scope ya no se usa de la misma manera
    return $query;
}
}