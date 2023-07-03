<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Resources\TMDbConnection;

class SearchController extends Controller
{
    //
    public function movie() {
        $search = 'Chicken';
        $connection = new TMDbConnection();
        $results = $connection->search($search);
        return view('pages.search', ['value' => $results]);
    }

    public function results(Request $request) {
        //take the search request and return the movie function
        $connection = new TMDbConnection();

    }
}
