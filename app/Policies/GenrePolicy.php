<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Genre;

class GenrePolicy
{
    /**
     * Create a new policy instance.
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
    
    public function create(User $user)
    {
        return ($user->type == 'A');
    }

    public function delete(User $user, Genre $model)
    {
        return ($user->type == 'A'); //admins podem apagar qualquer um exceto a si mesmo
    }
}
