<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MovieList;

class MovieListPolicy
{
    public function create(User $user)
    {
        return $user->isAdmin() || $user->id === $user->id;
    }

    public function edit(User $user, MovieList $movieList)
    {
        return $user->isAdmin() || $user->id === $movieList->user_id;
    }

    public function view(?User $user, MovieList $movieList)
    {
        return ($movieList->private === 0) 
        || ($movieList && ($user->isAdmin() || $user->id === $movieList->user_id));
    }
}
