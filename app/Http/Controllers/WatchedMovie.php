<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieList;
use Illuminate\Http\Request;

class WatchedMovie extends Controller
{
    public function __invoke(Request $request)
    {
        $movieListId = $request->input('movie_list_id');
        $movieId = $request->input('movie_id');

        $movieList = MovieList::findOrFail($movieListId);
        $movie = $movieList->movie()->where('movie_id', $movieId)->firstOrFail();

        $movie->pivot->watched = true;
        $movie->pivot->save();

        return redirect()->back();
    }
}
