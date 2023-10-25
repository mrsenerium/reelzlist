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
        $movieLists = $user->movieLists->all();

        dd($movieLists);
    }

    public function create(): view
    {
        //
        return view('pages.movieList.create');
    }

    public function store(Request $request): redirectResponse
    {
        //
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
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
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
