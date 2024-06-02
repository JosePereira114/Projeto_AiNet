<?php

namespace App\Policies;

use App\Models\User;


class UserPolicy
{

    public function viewAny(User $user)
    {
        return ($user->type == 'A');
    }

    public function viewUserClient(User $user)
    {
        return ($user->type == 'C');
    }

    public function view(User $user, User $model)
    {
        return (($user->type == 'A') && ($model->type != 'C')) || (($user->id == $model->id) && ($model->tipo == 'C'));
    }

    public function create(User $user)
    {
        return ($user->type == 'A');
    }

    public function update(User $user, User $model)
    {
        return ($user->type == 'A') && ($model->type != 'C'); 
    }

    public function delete(User $user, User $model)
    {
        return ($user->type == 'A') && ($user->id != $model->id); //admins podem apagar qualquer um exceto a si mesmo
    }

    public function restore(User $user, User $model)
    {
        return ($user->type == 'A');
    }


    public function forceDelete(User $user)
    {
        return ($user->tipo == 'A');
    }

    public function bloquear(User $user, User $model)
    {
        return ($user->tipo == 'A') && ($user->id != $model->id);
    }
}

