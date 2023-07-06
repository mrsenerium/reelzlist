<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Http\Resources\TMDbConnection;
use App\Models\Movie;
use Carbon\Carbon;

class SearchController extends Controller
{
    //
    public function movie(Request $request) {
        $randos = Movie::inRandomOrder()->take(10)->get();
        return view('pages.search', ['movies' => $randos]);
        /*$search = 'dances with wolves';
        $movies = Movie::where('title', 'like', '%'.$search.'%')->get()->toArray();
        //if(is_countable($movies) && count($movies) < 10) {
            $connection = new TMDbConnection();
            $results = $connection->search($search);
            //echo('<pre>');var_dump($results);die('</pre>');
            foreach($results->results as $result) {
                $movie = Movie::firstOrCreate(
                    ['title'         => $result->title],
                    ['overview'      => $result->overview,
                    'release_date'  => \Carbon\Carbon::parse($result->release_date)->format('Y-m-d'),
                    'tmdb_id'       => $result->id,
                ]);
                $movies[] = $movie;
            }
        //}
        return view('pages.search', ['movies' => $movies]);*/
    }

    public function results(Request $request) {
        $search = trim($request->search);
        $movies = Movie::where('title', 'like', '%'.$search.'%')->get()->toArray();
        //take the search request and return the movie function
        //if(is_countable($movies) && count($movies) < 10) {
            $connection = new TMDbConnection();
            $results = $connection->search($search);
            //echo('<pre>');var_dump($results);die('</pre>');
            foreach($results->results as $result) {
                $movie = Movie::firstOrCreate(
                    ['title'         => $result->title],
                    ['overview'      => $result->overview,
                    'release_date'  => \Carbon\Carbon::parse($result->release_date)->format('Y-m-d'),
                    'tmdb_id'       => $result->id,
                ]);
                $movies[] = $movie;
            }
        //}
        return view('pages.search', ['movies' => $movies, 'search' => $request->search]);
        $connection = new TMDbConnection();
    }
}
