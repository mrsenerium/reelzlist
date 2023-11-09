<?php

namespace App\Http\Controllers;

use App\Models\MovieList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovieListController extends Controller
{
    public function index()
    {
        if (! auth()->check()) {
            return redirect('/');
        }
        $user = auth()->user();
        $movieLists = $user->load('movie_list');

        /**
         * Todo: determine what you want to do here
         */
        dd($movieLists);
    }

    public function create(): view
    {
        return view('pages.movieList.create');
    }

    public function store(Request $request): redirectResponse
    {
        MovieList::create(['user_id' => auth()->user()->id, 'name' => $request->name]);

        return redirect(route('showProfile'));
    }

    public function show(string $id)
    {
        $movieList = MovieList::where('id', '=', $id)->with('movie')->first();

        return view('pages.movieList.show', ['movieList' => $movieList, 'movies' => $movieList->movie]);
    }

    public function edit(string $id)
    {
        $movieList = MovieList::where('id', $id)->first();

        return view('pages.movieList.edit', ['movieList' => $movieList]);
    }

    public function update(Request $request, string $id)
    {
        $movieList = MovieList::where('id', '=', $id)->with('movie')->first();
        $movieList->update([
            'name' => $request->name,
            'private' => $request->private ?? 0,
        ]);
        return view('pages.movieList.show', ['movieList' => $movieList, 'movies' => $movieList->movie]);
    }

    public function destroy(string $id)
    {
        $movieList = MovieList::where('id', '=', $id)->with('movie')->first();
        foreach($movieList->movie as $movie)
        {
            $movieList->Movie()->detach(['movie_id' => $movie]);
        }
        $movieList->delete();
        return redirect(route('showProfile'));
    }

    public function addMovieToList($movieList, $movie, Request $request): redirectResponse
    {
        $list = MovieList::where('id', '=', $movieList)->with('Movie')->first();
        $list->Movie()->attach(
            [
                'movie_id' => $movie,
            ]
        );

        return back();
    }

    public function removeMovieFromList($movieList, $movie, Request $request): redirectResponse
    {
        $list = MovieList::where('id', '=', $movieList)->with('Movie')->first();
        $list->Movie()->detach(
            [
                'movie_id' => $movie,
            ]
        );

        return back();
    }
}
