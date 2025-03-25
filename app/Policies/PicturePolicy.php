<?php

namespace App\Policies;

use App\Models\Picture;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PicturePolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Picture $picture): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Picture $picture): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the picture.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Picture  $picture
     * @return bool
     */
    public function delete(User $user, Picture $picture)
    {
        return $user->id === $picture->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Picture $picture): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Picture $picture): bool
    {
        return false;
    }
}
