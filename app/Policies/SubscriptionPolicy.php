<?php

namespace App\Policies;

use App\Models\User;

class SubscriptionPolicy
{
    public function viewAny(User $user)
    {
        return isset($user);
    }
}
