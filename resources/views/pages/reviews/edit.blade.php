@extends('layouts.no-sidebar')

@section('title', 'ReelzList - New Review')

@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="{{ asset('js/showStars.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/stars.js') }}" type="text/javascript"></script>
@endsection

@section('content')
    <div class="container">
        <h3>Edit Review for {{$movie->title}}</h3>

        {!! Form::model($review, ['route' => ['review.update', 'review' => $review->id], 'method' => 'put']) !!}
        {{ csrf_field() }}
        {!! Form::hidden('movie_id', $movie->id) !!}
        {!! Form::hidden('user_id', auth()->user()->id) !!}

        <div class="row">
            <label class="form-label">Rating:</label>
            <div class="col-6 mb-2">
                <span class="fa fa-star star" data-rating=1></span>
                <span class="fa fa-star star" data-rating=2></span>
                <span class="fa fa-star star" data-rating=3></span>
                <span class="fa fa-star star" data-rating=4></span>
                <span class="fa fa-star star" data-rating=5></span>
                {!! Form::hidden('rating', $review->rating, ['id' => 'selected-rating']) !!}
                @error('rating')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <div class="col-6">
                {!! Form::label('name', 'Name of Review:') !!}
                {!! Form::text('name', $review->name, ['class' => 'form-control']) !!}
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-6">
                {!! Form::label('private', 'Private') !!}
                {!! Form::checkbox('private', 1, $review->private, ['class' => 'form-check']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-9">
                {!! Form::label('body', 'Review') !!}
                {!! Form::textArea('body', $review->body, ['class' => 'form-control']) !!}
                @error('body')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-6 mt-2">
                {!! Form::submit('Submit Review', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('review.show', ['review' => $review]) }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>

        {!! Form::close() !!}
        <form method="POST" action="{{ route('review.destroy', ['review' => $review->id]) }}" onsubmit="return confirm('Are you sure you want to delete this review?')" class="mt-2 form-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete Review</button>
        </form>
    </div>

@endsection
