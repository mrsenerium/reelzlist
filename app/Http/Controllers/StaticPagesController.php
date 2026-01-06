<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class StaticPagesController extends Controller
{
    public function home()
    {
        $move = Movie::where('tmdb_id', 458305)->first();
        $movies = Movie::whereNotNull('poster_url')
            ->inRandomOrder()
            ->get()
            ->filter(fn ($movie) => $movie->checkPoster())
            ->take(12)
            ->values();

        return view('pages.static.home', ['movies' => $movies]);
    }

    public function about()
    {
        return view('about');
    }

    public function features()
    {
        return view('pages.static.features');
    }
}
