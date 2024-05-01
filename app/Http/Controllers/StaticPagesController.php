<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class StaticPagesController extends Controller
{
    public function home()
    {
        $movies = Movie::whereNotNull('poster_url')
            ->inRandomOrder()
            ->take(12)
            ->get();
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
