<?php

namespace App\Http\Controllers;

use App\Http\Requests\WhatToWatchRequest;
use Illuminate\View\View;

class WhatToWatchController extends Controller
{
    public function index(WhatToWatchRequest $request): View
    {
        $user = $request->user();

        return view('pages.whatToWatch.index', [
            'movies' => $user->suggestMovies(
                $request->genre(),
                $request->year(),
                $request->hideWatched(),
            ),
            'genreList' => $user->listedGenres(),
            'hasLists' => $user->movie_list()->exists(),
        ]);
    }
}
