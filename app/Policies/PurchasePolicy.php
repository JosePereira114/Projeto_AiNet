<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Purchase;

class PurchasePolicy
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
    public function view(User $user, Purchase $purchase): bool|null
    {
        //
        return true;
    }
    
    public function create(User $user)
    {
        return true;
    }

    public function delete(User $user, Purchase $model)
    {
        return true; //admins podem apagar qualquer um exceto a si mesmo
    }

    public function update(User $user, Purchase $purchase): bool|null
    {
        //
        return true;
    }

    public function restore(User $user, Purchase $purchase): bool|null
    {
        //
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Purchase $purchase): bool|null
    {
        //
        return true;
    }
}
