<?php

namespace App\Http\Controllers;

use App\Http\Resources\TMDbConnection;
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
        return view('pages.movies.create');
    }

    public function store(Request $request)
    {
        $tmdbData = (new TMDbConnection)->singleMovieData($request->id);

        $movie = Movie::create([
            'title' => $tmdbData->title ?? null,
            'overview' => $tmdbData->overview ?? null,
            'imdb_id' => $tmdbData->imdb_id ?? null,
            'runtime' => $tmdbData->runtime ?? null,
            'box_office' => $tmdbData->revenue ?? null,
            'budget' => $tmdbData->budget ?? null,
            'release_date' => $tmdbData->release_date,
            'mpaa_rating' => '',
            'poster_url' => 'https://image.tmdb.org/t/p/w300_and_h450_bestv2/' . $tmdbData->poster_path ?? null,
        ]);

        return redirect()->route('movies.show', $movie->slug);
    }

    public function show(Movie $movie)
    {
        $movie->updateTMDBData();
        $movie->updateOMDBData();

        $watchProviders = $movie['tmdb_id']
            ? $movie->getWatchProviders($movie['tmdb_id'])
            : null;

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
