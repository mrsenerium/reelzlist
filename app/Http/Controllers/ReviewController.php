<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Movie;

class ReviewController extends Controller
{
    public function index()
    {
        return view('pages.reviews.index', ['reviews' =>
            Review::where('user_id', auth()->user()->id)
                ->orderBy('updated_at', 'desc')
                ->get()
        ]);
    }

    public function create(string $user_id, string $movie_id)
    {
        return view('pages.reviews.create',
            ['movie' => Movie::where('id', $movie_id)->first()]
        );
    }

    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Might not need this
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
