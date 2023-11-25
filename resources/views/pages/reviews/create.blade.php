@extends('layouts.no-sidebar')

@section('title', 'ReelzList - New Review')

@section('scripts')
    <link type="text/css" href="{{ asset('css/rating.min.css') }}" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .checked {
            color: gold;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('.star');
            const hiddenField = document.getElementById('selected-rating');

            stars.forEach(star => {
                star.addEventListener('click', () => {
                    const rating = star.getAttribute('data-rating');
                    stars.forEach(star => star.classList.remove('checked'));
                    hiddenField.value = rating;
                    document.querySelectorAll('.star').forEach(star => {
                        if (parseInt(star.getAttribute('data-rating')) <= parseInt(rating)) {
                            star.classList.add('checked');
                        }
                    });
                });
            });
        });
    </script>
@endsection

@section('content')
    <div class="container">
        <h3>New Review for {{$movie->title}}</h3>
        <p>
            This is where you will write your review
        </p>

        {!! Form::open(['route' => 'review.store', 'method' => 'post']) !!}
        {{ csrf_field() }}
        {!! Form::hidden('movie_id', $movie->id) !!}

        <div class="row">
            <label class="form-label">Rating:</label>
            <div class="col-6 mb-2">
                <span class="fa fa-star star" data-rating=1></span>
                <span class="fa fa-star star" data-rating=2></span>
                <span class="fa fa-star star" data-rating=3></span>
                <span class="fa fa-star star" data-rating=4></span>
                <span class="fa fa-star star" data-rating=5></span>
                {!! Form::hidden('selected-rating', 0, ['id' => 'selected-rating']) !!}
            </div>
        </div>

        <div class="form-group row">

            <div class="col-6">
                {!! Form::label('name', 'Name of Review:') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>
            <div class="col-6">
                {!! Form::label('private', 'Private') !!}
                {!! Form::checkbox('private', 1, 0, ['class' => 'form-check']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-9">
                {!! Form::label('body', 'Review') !!}
                {!! Form::textArea('body', null, ['class' => 'form-control', 'required' => 'required']) !!}
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
