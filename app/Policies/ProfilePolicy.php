<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Profile;

class ProfilePolicy
{
    public function view(User $user, Profile $profile): bool
    {
        return $user->isAdmin() || $user->id === $profile->user_id;
    }

    public function edit(User $user, Profile $profile): bool
    {
        return $user->isAdmin() || $user->id === $profile->user_id;
    }
}
