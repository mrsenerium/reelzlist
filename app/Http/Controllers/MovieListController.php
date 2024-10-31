<?php

namespace App\Http\Controllers;

use App\Models\MovieList;
use App\Models\User;
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
        $this->authorize('create', MovieList::class);
        $user = User::query()
            ->where('id', auth()->user()->id)
            ->with('profile')
            ->first();
        MovieList::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'private' => $request->private ?? 0,
        ]);

        return redirect(route('profile.show', ['profile' => $user->profile->id]));
    }

    public function show(string $id)
    {
        $movieList = MovieList::where('id', $id)->with('movie')->first();
        $this->authorize('view', $movieList);

        return view('pages.movieList.show', ['movieList' => $movieList, 'movies' => $movieList->movie]);
    }

    public function edit(string $id)
    {
        $movieList = MovieList::where('id', $id)->first();
        $this->authorize('edit', $movieList);

        return view('pages.movieList.edit', ['movieList' => $movieList]);
    }

    public function update(Request $request, string $id)
    {
        $movieList = MovieList::where('id', $id)->with('movie')->first();
        $this->authorize('edit', $movieList);

        $movieList->update([
            'name' => $request->name,
            'private' => $request->private ?? 0,
        ]);

        return view('pages.movieList.show', ['movieList' => $movieList, 'movies' => $movieList->movie]);
    }

    public function destroy(string $id)
    {
        $user = User::query()
            ->where('id', auth()->user()->id)
            ->with('profile')
            ->first();
        $movieList = MovieList::where('id', $id)->with('movie')->first();
        $this->authorize('edit', $movieList);

        foreach ($movieList->movie as $movie) {
            $movieList->Movie()->detach(['movie_id' => $movie]);
        }
        $movieList->delete();

        return redirect(route('profile.show', ['profile' => $user->profile->id]));
    }
}
