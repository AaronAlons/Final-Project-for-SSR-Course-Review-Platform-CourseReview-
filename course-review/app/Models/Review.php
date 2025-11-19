<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    
    // DEFINICIÓN CLAVE: Permite la Asignación Masiva de estos campos.
    protected $fillable = [
    'user_id',
    'course_id',
    'rating',
    'content', // <-- ¡Volvemos a 'content'!
];

    // Relación: Una reseña pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relación: Una reseña pertenece a un curso
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}