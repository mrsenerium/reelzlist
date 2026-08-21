<?php

namespace App\Http\Controllers;

use App\Http\Resources\TMDbConnection;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;

class TmdbDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $q = request()->input('q');
        if ($q) {
            $tmdbSearch = (new TMDbConnection)->search($q)->results;
            $tmdbSearch = collect($tmdbSearch)->map(function ($movie) {
                $genres = Genre::whereIn('tmdb_id', $movie->genre_ids ?? [])->get();
                $movie->genres = $genres;

                return $movie;
            });

            return view('pages.tmdb.index', [
                'movies' => $tmdbSearch,
                'q' => $q,
            ]);
        } else {
            return view('pages.tmdb.index', [
                'q' => $q,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movie = Movie::where('tmdb_id', $id)->first();
        if (! $movie) {
            $tmdbData = (new TMDbConnection)->singleMovieData($id);
            $movie = Movie::firstOrCreate([
                'title' => $tmdbData->title ?? null,
                'overview' => $tmdbData->overview ?? null,
                'imdb_id' => $tmdbData->imdb_id ?? null,
                'runtime' => $tmdbData->runtime ?? null,
                'box_office' => $tmdbData->revenue ?? null,
                'budget' => $tmdbData->budget ?? null,
                'release_date' => $tmdbData->release_date,
                'tmdb_id' => $tmdbData->id,
            ]);
            foreach ($tmdbData->genres as $genre) {
                $genre = Genre::firstOrCreate([
                    'tmdb_id' => $genre->id,
                    'name' => $genre->name,
                ]);
                $movie->addGenre($genre);
            }
            $movie->updateOMDBData();
        }

        return redirect()->route('movies.show', $movie->slug);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
