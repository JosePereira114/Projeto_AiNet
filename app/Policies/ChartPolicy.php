<?php

namespace App\Policies;

use App\Models\User;

class ChartPolicy
{
    public function viewAny(User $user): bool|null
    {
        //
        return ($user->type == 'A');
    }
}
