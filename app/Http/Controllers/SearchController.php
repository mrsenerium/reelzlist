<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Resources\TMDbConnection;
use App\Models\Movie;

class SearchController extends Controller
{
    //
    public function movie() {
        $search = 'crow';
        $movies = Movie::where('title', 'like', '%'.$search.'%')->get()->toArray();
        //if(is_countable($movies) && count($movies) < 10) {
            $connection = new TMDbConnection();
            $results = $connection->search($search);
            //echo('<pre>');var_dump($results);die('</pre>');
            foreach($results->results as $result) {
                $movie = Movie::firstOrCreate(
                    ['title'         => $result->title],
                    ['overview'      => $result->overview,
                    'release_date'  => $result->release_date,
                    'tmdb_id'       => $result->id,
                ]);
                $movies[] = $movie;
            }
        //}
        return view('pages.search', ['movies' => $movies]);
    }

    public function results(Request $request) {
        //take the search request and return the movie function
        $connection = new TMDbConnection();

    }
}
