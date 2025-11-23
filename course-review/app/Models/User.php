<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    /**
     * Get the courses that the user has created.
     */
    public function courses(): HasMany // <<-- RELACIÓN AÑADIDA
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Get the reviews that the user has made.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // =========================================================================
    // LÓGICA DE ROLES (ADMINISTRACIÓN)
    // =========================================================================

    /**
     * Determina si el usuario tiene un rol de administrador global para cursos.
     *
     * @return bool
     */
    public function isAdminForCourses(): bool
    {
        // 🔥 LÓGICA DE EJEMPLO: El usuario con ID = 1 es el administrador global.
        // En una aplicación real, esto se basaría en un campo 'role' o una relación de tabla.
        return $this->id === 2;
    }
}