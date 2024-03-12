<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    
    public function edit(User $user, User $model)
    {
        return $user->isAdmin();
    }

    public function view(User $user, User $model)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, User $model)
    {
        return $user->isAdmin();
    }
}
