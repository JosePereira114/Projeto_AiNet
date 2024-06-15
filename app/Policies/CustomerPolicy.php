<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Customer;

class CustomerPolicy
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
        return ($user->type == 'A') || ($user->type == 'E');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Customer $customer): bool|null
    {
        //
        return true;
    }
    
    public function create(User $user)
    {
        return ($user->type == 'A');
    }

    public function delete(User $user, Customer $model)
    {
        return ($user->type == 'A');
    }

    public function update(User $user): bool|null
    {
        return ($user->type == 'A'); 
    }

    public function restore(User $user, Customer $customer): bool|null
    {
        //
        return ($user->type == 'A');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Customer $customer): bool|null
    {
        return ($user->type == 'A'); 
    }
}
