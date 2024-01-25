<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Review;

class ReviewPolicy
{
    public function create(User $user)
    {
        return isset($user);
    }
    
    public function edit(User $user, Review $review)
    {
        return $user->isAdmin() || $user->id === $review->user_id;
    }

    public function view(?User $user, Review $review)
    {
        return ($review->private === 0) || ($user && ($user->isAdmin() || $user->id === $review->user_id));
    }
}
