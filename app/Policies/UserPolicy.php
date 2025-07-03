<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function accessDashboard(User $user): bool
    {
        return $user->isLister();
    }
}
