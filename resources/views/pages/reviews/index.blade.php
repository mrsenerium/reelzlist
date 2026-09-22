@extends('layouts.no-sidebar')

@section('title', 'ReelzList - Your Reviews')

@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-9">
                <h2>Your reviews</h2>
            </div>
            <div class="col-3 text-end">
                <a href="{{ route('movies.index') }}" class="btn btn-info">Find a movie to review</a>
            </div>
        </div>

        <form method="GET" action="{{ route('review.index') }}" class="mt-2 mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="movie" class="form-label">Movie</label>
                    <input
                        type="text"
                        name="movie"
                        id="movie"
                        class="form-control"
                        placeholder="Movie name"
                        value="{{ $movie }}"
                    >
                </div>
                <div class="col-md-4">
                    <label for="title" class="form-label">Review title</label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control"
                        placeholder="Review title"
                        value="{{ $title }}"
                    >
                </div>
                <div class="col-md-2">
                    <label for="rating" class="form-label">Star rating</label>
                    <select name="rating" id="rating" class="form-select">
                        <option value="">All</option>
                        @for ($stars = 1; $stars <= 5; $stars++)
                            <option value="{{ $stars }}" @selected((string) $rating === (string) $stars)>
                                {{ $stars }} {{ $stars === 1 ? 'star' : 'stars' }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </div>

            @if ($movie || $title || $rating)
                <div class="mt-3">
                    <a href="{{ route('review.index') }}" class="btn btn-outline-secondary btn-sm">Reset Filters</a>
                </div>
            @endif
        </form>

        @if ($reviews->isEmpty())
            <p>{{ ($movie || $title || $rating) ? 'No reviews match your filters.' : 'You have not written any reviews yet.' }}</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Movie</th>
                            <th>Review title</th>
                            <th>Rating</th>
                            <th>Privacy</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reviews as $review)
                            <tr>
                                <td>
                                    @if ($review->movie)
                                        <a href="{{ route('movies.show', $review->movie->slug) }}">{{ $review->movie->title }}</a>
                                    @else
                                        Unknown movie
                                    @endif
                                </td>
                                <td>{{ $review->name }}</td>
                                <td>
                                    @for ($star = 1; $star <= 5; $star++)
                                        <span class="fa fa-star star @if ($star <= $review->rating) checked @endif"></span>
                                    @endfor
                                </td>
                                <td>{{ $review->private ? 'Private' : 'Public' }}</td>
                                <td>
                                    <a href="{{ route('review.show', ['review' => $review->id]) }}" class="btn btn-sm btn-success">View</a>
                                    @can('edit', $review)
                                        <a href="{{ route('review.edit', ['review' => $review->id]) }}" class="btn btn-sm btn-info">Edit</a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $reviews->links() }}
        @endif
    </div>
@endsection
