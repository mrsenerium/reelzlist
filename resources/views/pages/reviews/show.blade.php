@extends('layouts.no-sidebar')

@section('title', 'ReelzList - Login')

@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="{{ asset('js/showStars.js') }}" type="text/javascript"></script>
@endsection

@section('content')
    <div class="container">


        <h2 class="mt-2 mb-2">{{ $movie->title }}</h2>
        <div class="row mb-2">
            <div class="col-2">
                Review Title:
            </div>
            <div class="col-9">
                {{ $review->name }}
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-2">
                Privacy:
            </div>
            <div class="col-9">
                {{ $review->private ? 'Private' : 'Public' }}
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-2">
                Rating:
            </div>
            <div class="col-9">
                <span class="fa fa-star star" data-rating=1></span>
                <span class="fa fa-star star" data-rating=2></span>
                <span class="fa fa-star star" data-rating=3></span>
                <span class="fa fa-star star" data-rating=4></span>
                <span class="fa fa-star star" data-rating=5></span>
                <input type="hidden" id="selected-rating" value="{{ $review->rating }}">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-2">
                Body of Review:
            </div>
            <div class="col-9">
                {!! nl2br(e($review->body)) !!}
            </div>
        </div>
        <a href="{{ route('movies.show', ['movie' => $movie->slug]) }}" class="btn btn-success">Go to Movie</a>
        <a href="{{ route('review.edit', ['review' => $review->id]) }}" class="btn btn-info">Edit Movie Review</a>
    </div>

@endsection
