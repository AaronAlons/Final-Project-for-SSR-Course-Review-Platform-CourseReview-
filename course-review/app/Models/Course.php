<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Para usar el 'slug' en la URL en lugar del ID (Route Model Binding)
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
