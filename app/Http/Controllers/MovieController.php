<?php

namespace App\Http\Controllers;

use App\Http\Resources\TMDbConnection;
use App\Models\Movie;
use App\Models\MovieList;
use App\Models\Review;
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
                ->paginate(25)
                ->appends(['q' => $q]),
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
            'tmdb_id' => $tmdbData->id,
        ]);
        $movie->updateOMDBData();

        return redirect()->route('movies.show', $movie->slug);
    }

    public function show(Movie $movie)
    {
        $movie->updateTMDBData();
        $movie->updateOMDBData();

        $otherReviewsQuery = Review::query()
            ->where('movie_id', $movie->id)
            ->where('private', '0')
            ->orderBy('rating', 'DESC');

        if (auth()->user()) {
            $movieLists = MovieList::query()
                ->when(auth()->user(), function ($movieLists) {
                    $movieLists->where('user_id', auth()->user()->id);
                })
                ->get();

            $review = Review::query()
                ->where('user_id', auth()->user()->id)
                ->where('movie_id', $movie->id)
                ->first();

            $watchProviders = $movie['tmdb_id']
                ? $movie->getWatchProviders($movie['tmdb_id'])
                : null;

            $watchProviders = $watchProviders->US ?? null;

            $otherReviewsQuery->where('user_id', '!=', auth()->user()->id);
        }

        $otherReviews = $otherReviewsQuery->paginate(10);

        return view(
            'pages.movies.show',
            [
                'movie' => $movie->toArray(),
                'watchProviders' => $watchProviders ?? null,
                'movieLists' => $movieLists ?? null,
                'review' => $review ?? null,
                'otherReviews' => $otherReviews ?? null,
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
