<?php

namespace App\Policies;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PetPolicy
{
    public function edit(User $user, Pet $pet): bool
    {
        return $pet->lister()->is($user);
    }

    public function delete(User $user, Pet $pet): bool
    {
        return $pet->lister()->is($user);
    }

    public function create(User $user): bool
    {
        return $user->isLister();
    }
}
