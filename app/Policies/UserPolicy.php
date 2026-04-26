<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Company $company): bool
    {  
        if($user->hasRole('SuperAdmin')) {
            return true;
        }
        if($user->hasRole('Admin') && $user->company_id === $company->id) {
            return true;
        }
        return false;
    }

    
}
