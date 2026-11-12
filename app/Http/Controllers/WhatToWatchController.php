<?php

namespace App\Http\Controllers;

use App\Http\Requests\WhatToWatchRequest;
use Illuminate\View\View;

class WhatToWatchController extends Controller
{
    public function index(WhatToWatchRequest $request): View
    {
        $user = $request->user();

        $movies = $user->suggestMovies(
                $request->genre(),
                $request->year(),
                $request->hideWatched(),
            );

        $movies->collect()->transform(function ($movie) {
            $movie->watch_providers = $movie->getWatchProviders($movie->tmdb_id);

            $movie->watch_providers = $movie->filterProviders(
                $movie->watch_providers->US ?? null,
                auth()->user()->subscriptions
            );
        });

            return view('pages.whatToWatch.index', [
                'movies' => $movies,
                'genreList' => $user->listedGenres(),
                'hasLists' => $user->movie_list()->exists(),
            ]);
    }
}
