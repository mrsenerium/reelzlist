<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\MovieList;
use Illuminate\View\View;

class MovieListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Display all lists for said User
        //Provide Access to CRUDdy things

        if (!Auth::check()) {
            return redirect('/');
        }
        $user = Auth::user();
        $movieLists = $user->movieLists->all();

        dd($movieLists);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : view
    {
        //
        return view('pages.movieList.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : redirectResponse
    {
        //
        MovieList::create(['user_id' => auth()->user()->id, 'name' => $request->name]);
        return redirect(route('showProfile'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movieList = MovieList::where('id', '=', $id)->with('movie')->first();
        return view('pages.movieList.show', ['movieList' => $movieList, 'movies' => $movieList->movie]);
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