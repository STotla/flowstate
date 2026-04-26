<?php

namespace App\Policies;

use App\Models\User;

class ShorturlPolicy
{

    public function create(User $user): bool
    {
        if($user->hasRole('SuperAdmin')){
            return false;
        }
        return true;
    }
}