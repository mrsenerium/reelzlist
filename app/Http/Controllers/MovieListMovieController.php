<?php

namespace App\Http\Controllers;

use App\Models\MovieList;
use Illuminate\Http\Request;

class MovieListMovieController extends Controller
{
    public function store(Request $request, MovieList $movieList)
    {
        $list = MovieList::where('id', $movieList)->with('Movie')->first();
        $this->authorize('edit', $movieList);

        $movieList->addMovieToList($request->movie_id);

        return redirect()->back()->with('success', 'Movie added to list.');
    }

    public function destroy(MovieList $movieList, $movie)
    {
        $list = MovieList::where('id', $movieList)->with('Movie')->first();
        $this->authorize('edit', $movieList);

        $movieList->removeMovieFromList($movie);

        return redirect()->back()->with('success', 'Movie removed from list.');
    }
}
