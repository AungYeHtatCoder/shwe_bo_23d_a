<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    // admin only update balance 
    public function updateAdminBalance(User $user)
    {
        return $user->hasRole('Admin');
    }
}