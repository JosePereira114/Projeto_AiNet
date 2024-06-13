<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Screening;

class ScreeningPolicy
{
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
    public function view(User $user, Screening $screening): bool|null
    {
        //
        return true;
    }
    
    public function create(User $user)
    {
        return ($user->type == 'A');
    }

    public function delete(User $user, Screening $model)
    {
        return ($user->type == 'A'); //admins podem apagar qualquer um exceto a si mesmo
    }

    public function update(User $user, Screening $screening): bool|null
    {
        return ($user->type == 'A'); 
    }

    public function restore(User $user, Screening $screening): bool|null
    {
        //
        return ($user->type == 'A');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Screening $screening): bool|null
    {
        return ($user->type == 'A'); 
    }

}
