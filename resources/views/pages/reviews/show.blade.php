@extends('layouts.no-sidebar')

@section('title', 'ReelzList - Login')

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
                Figure this out!!!!
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
