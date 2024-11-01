<?php

namespace App\Policies;

use App\Models\Profile;
use App\Models\User;

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
