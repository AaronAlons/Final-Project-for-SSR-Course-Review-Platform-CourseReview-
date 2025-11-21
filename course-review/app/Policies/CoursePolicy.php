<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CoursePolicy
{
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
     */
    public function update(User $user, Course $course): bool
{
    return $user->id === $course->user_id; // <-- Debe ser esta línea para funcionar
}

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Course $course): bool
    {
        // Aplica la misma lógica para eliminar.
        return $user->id === $course->user_id;
    }
}