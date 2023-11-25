@extends('layouts.no-sidebar')

@section('title', 'ReelzList - New Review')

@section('content')
    <div class="container">
        <h3>New Review for {{$movie->title}}</h3>
        <p>
            This is where you will write your review
        </p>

        {!! Form::model($review, ['route' => ['review.update', 'review' => $review->id], 'method' => 'put']) !!}
        {{ csrf_field() }}
        {!! Form::hidden('movie_id', $movie->id) !!}

        <div class="form-group row">

            <div class="rating">
                @for ($i = 1; $i <= 5; $i++)
                    <span class="star {{ $i <= $userRating->rating ? 'filled' : '' }}"></span>
                @endfor
            </div>

            <div class="col-6">
                {!! Form::label('name', 'Name of Review:') !!}
                {!! Form::text('name', $review->name, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>
            <div class="col-6">
                {!! Form::label('private', 'Private') !!}
                {!! Form::checkbox('private', 1, $review->private, ['class' => 'form-check']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-9">
                {!! Form::label('body', 'Review') !!}
                {!! Form::textArea('body', $review->body, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-3 mt-2">
                {!! Form::submit('Submit Review', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>

        {!! Form::close() !!}
    </div>

@endsection
