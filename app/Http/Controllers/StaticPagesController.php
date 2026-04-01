<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class StaticPagesController extends Controller
{
    public function home()
    {
        $movies = Movie::whereNotNull('poster_url')
            ->frontpageSafe()
            ->inRandomOrder()
            ->limit(30)
            ->get();

        return view('pages.static.home', ['movies' => $movies]);
    }

    public function features()
    {
        return view('pages.static.features');
    }
}
