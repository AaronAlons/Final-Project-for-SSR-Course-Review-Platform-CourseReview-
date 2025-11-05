<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ // <-- ESTE ES EL BLOQUE NUEVO
        'title',
        'slug',
        'description',
        'instructor',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Para usar el slug en la URL en lugar del ID (Route Model Binding)
    public function getRouteKeyName()
    {
        return 'slug';
    }
}