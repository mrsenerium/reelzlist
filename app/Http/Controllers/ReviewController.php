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
        return view(
            'pages.reviews.create',
            ['movie' => Movie::where('id', $movie_id)->first()]
        );
    }

    public function store(Request $request)
    {
        $review = Review::create([
            'user_id' => auth()->user()->id,
            'movie_id' => $request->movie_id,
            'name' => $request->name,
            'rating' => $request->rating,
            'private' => $request->private ?? 0,
            'body' => $request->body,
        ]);

        $review->load('Movie');
        return view('pages.reviews.show', [
            'review' => $review,
            'movie' => $review->movie
        ]);
    }

    public function show(string $id)
    {
        $review = Review::where('id', $id)->with('Movie')->first();
        $this->authorize('view', $review);
        return view('pages.reviews.show', [
            'review' => $review,
            'movie' => $review->movie
        ]);
    }

    public function edit(string $id)
    {
        $review = Review::where('id', $id)
            ->with('Movie')
            ->first();

        $this->authorize('edit', $review);

        return view('pages.reviews.edit', [
            'review' => $review,
            'movie' => $review->movie
        ]);
    }

    public function update(Request $request, string $id)
    {
        $review = Review::where('id', $id)->with('Movie')->first();

        $this->authorize('edit', $review);

        $review->update([
            'user_id' => auth()->user()->id,
            'movie_id' => $request->movie_id,
            'name' => $request->name,
            'rating' => $request->rating,
            'private' => $request->private ?? 0,
            'body' => $request->body,
        ]);

        return view('pages.reviews.show', [
            'review' => $review,
            'movie' => $review->movie
        ]);
    }

    public function destroy(string $id)
    {
        $review = Review::where('id', $id)->with('Movie')->first();
        $this->authorize('edit', $review);
        $movie = $review->movie;
        $review->delete();
        return redirect()->route('movies.show', $movie->slug);
    }
}
