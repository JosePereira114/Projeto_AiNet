<?php

namespace App\Policies;

use App\Models\Theater;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TheaterPolicy
{
    /**
     * Determine whether the user can view any models.
     */

    public function before(?User $user, string $ability): bool|null
    {
        if ($user?->admin) {
            return true;
        }
        // When "Before" returns null, other methods (eg. viewAny, view, etc...) will be
        // used to check the user authorizaiton
        return null;
    }
    
    public function viewAny(User $user): bool|null
    {
        //
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Theater $theater): bool|null
    {
        //
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool|null
    {
        //
        return ($user->type == 'A');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool|null
    {
        //
        return ($user->type == 'A');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool|null
    {
        //
        return ($user->type == 'A');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Theater $theater): bool|null
    {
        //
        return ($user->type == 'A');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Theater $theater): bool|null
    {
        //
        return ($user->type == 'A');
    }
}
