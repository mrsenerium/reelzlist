<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use NumberFormatter;

class MovieController extends Controller
{
    public function single(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);
        $movie->update_self();
        /**
         * get the model from the database
         * if it hasn't been updated in over a month make the model update itself
         * package the information
         * return single movie blade
         */
        if(isset($movie['budget'])) {
            $formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
            $formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);
            $movie['budget'] = $formatter->format((int) $movie['budget']);
            $movie['box_office'] = $formatter->format((int) $movie['box_office']);
        }
        return view('pages.singleMovie', ['movie' => $movie->toArray()]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        //
    }
}
