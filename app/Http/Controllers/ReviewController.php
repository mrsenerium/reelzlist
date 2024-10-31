<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Movie;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        return view('pages.reviews.index', ['reviews' => Review::where('user_id', auth()->user()->id)
            ->orderBy('updated_at', 'desc')
            ->get(),
        ]);
    }

    public function create(Request $request)
    {
        $this->authorize('create', Review::class);
        $movie_id = $request->query('movie_id');

        return view(
            'pages.reviews.create',
            ['movie' => Movie::where('id', $movie_id)->first()]
        );
    }

    public function store(ReviewRequest $request)
    {
        $this->authorize('create', Review::class);
        $review = Review::create($request->validationData());
        $review->load('Movie');

        return view('pages.reviews.show', [
            'review' => $review,
            'movie' => $review->movie,
        ]);
    }

    public function show(string $id)
    {
        $review = Review::where('id', $id)->with('Movie')->first();
        $this->authorize('view', $review);

        return view('pages.reviews.show', [
            'review' => $review,
            'movie' => $review->movie,
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
            'movie' => $review->movie,
        ]);
    }

    public function update(ReviewRequest $request, string $id)
    {
        $review = Review::where('id', $id)->with('Movie')->first();

        $this->authorize('edit', $review);

        $review->update($request->validationData());

        return view('pages.reviews.show', [
            'review' => $review,
            'movie' => $review->movie,
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
