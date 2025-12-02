<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CoursePolicy
{
    /**
     * Otorga permisos de superadministrador.
     * Si el usuario es un administrador de cursos, se permite cualquier acción.
     */
    public function before(User $user, string $ability): ?bool
    {
        // Si el usuario es un administrador de cursos, devuelve true para saltar el resto de comprobaciones.
        if ($user->isAdminForCourses()) {
            return true;
        }

        return null; // Permitir que la política normal se ejecute.
    }

    /**
     * Determine whether the user can view any models.
     * (Generalmente se usa para acceder a la página de índice)
     */
    public function viewAny(User $user): bool
    {
        return true; // Cualquier usuario autenticado puede ver la lista de sus cursos.
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Cualquier usuario autenticado puede crear cursos.
    }

    /**
     * Determine whether the user can update the model (edit/update).
     * Solo si el usuario es el creador del curso.
     */
    public function update(User $user, Course $course): bool
    {
        return $user->id === $course->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     * Solo si el usuario es el creador del curso.
     */
    public function delete(User $user, Course $course): bool
    {
        return $user->id === $course->user_id;
    }
}