<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMovieListMovieRequest;
use App\Models\Movie;
use App\Models\MovieList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MovieListMovieController extends Controller
{
    public function store(Request $request, MovieList $movieList): RedirectResponse
    {
        $this->authorize('edit', $movieList);

        $movieList->addMovieToList($request->movie_id);

        return redirect()->back()->with('success', 'Movie added to list.');
    }

    public function update(UpdateMovieListMovieRequest $request, MovieList $movieList, Movie $movie): RedirectResponse
    {
        if (! $movieList->movie()->where('movies.id', $movie->id)->exists()) {
            abort(404);
        }

        $movieList->movie()->updateExistingPivot($movie->id, [
            'is_watched' => $request->boolean('is_watched'),
        ]);

        return redirect()->back()->with('success', 'List updated.');
    }

    public function destroy(MovieList $movieList, Movie $movie): RedirectResponse
    {
        $this->authorize('edit', $movieList);

        $movieList->removeMovieFromList($movie->id);

        return redirect()->back()->with('success', 'Movie removed from list.');
    }
}
