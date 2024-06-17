<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ticket;

class TicketPolicy
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
        return ($user->type == 'A');
    }

    public function Qr(User $user): bool|null
    {
        //
        return ($user->type == 'A') || ($user->type == 'E');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool|null
    {
        //
        return ($user->type == 'A');
    }
    
    public function create(User $user)
    {
        return ($user->type == 'A');
    }

    public function delete(User $user, Ticket $model)
    {
        return ($user->type == 'A'); //admins podem apagar qualquer um exceto a si mesmo
    }

    public function update(User $user, Ticket $ticket): bool|null
    {
        //
        return ($user->type == 'A');
    }

    public function restore(User $user, Ticket $ticket): bool|null
    {
        //
        return ($user->type == 'A');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ticket $ticket): bool|null
    {
        //
        return ($user->type == 'A');
    }
}
