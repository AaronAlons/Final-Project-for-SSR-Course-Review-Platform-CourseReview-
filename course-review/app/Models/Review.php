<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ // <-- ESTE ES EL BLOQUE NUEVO
        'rating',
        'comment',
        'user_id',
        // 'course_id' no es necesario aquí porque lo llenamos
        // automáticamente con la relación $course->reviews()->create()
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}