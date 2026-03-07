<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class StaticPagesController extends Controller
{
    public function home()
    {
        $move = Movie::where('tmdb_id', 458305)->first();
        // $movies = Movie::whereNotNull('poster_url')
        //     ->inRandomOrder()
        //     ->get()
        //     ->filter(fn ($movie) => $movie->checkPoster())
        //     ->take(12)
        //     ->values();
        // todo: clean this up later
        $movies = Movie::whereNotNull('poster_url')
            ->frontpageSafe()
            ->inRandomOrder()
            ->limit(30)
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

    public function openai()
    {
        $openAIService = new \App\Services\OpenAIService();
        $response = $openAIService->respond('Hello, OpenAI!');
        dd(response()->json(['response' => $response]));

        // $openAIService = new \App\Services\OpenAIService();
        // $models = $openAIService->listModels();
        // dd($models);
    }
}
