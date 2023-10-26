<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieList;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $q = request()->input('q');

        return view('pages.movies.index', [
            'movies' => Movie::query()
                ->when($q, function ($movies, $q) {
                    $movies->where('title', 'like', "%{$q}%");
                })
                ->get(),
            'q' => $q,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Movie $movie)
    {
        $movie->updateData();

        $watchProviders = $movie['tmdb_id'] ? $movie->getWatchProviders($movie['tmdb_id']) : null;
        $watchProviders = $watchProviders->US ?? null;

        $movieLists = MovieList::query()
            ->when(auth()->user(), function ($movieLists) {
                $movieLists->where('user_id', auth()->user()->id);
            })
            ->get();

        return view(
            'pages.movies.show',
            [
                'movie' => $movie->toArray(),
                'watchProviders' => $watchProviders,
                'movieLists' => $movieLists,
            ]
        );
    }

    public function edit(Movie $movie)
    {
        //
    }

    public function update(Request $request, Movie $movie)
    {
        //
    }

    public function destroy(Movie $movie)
    {
        //
    }
}
