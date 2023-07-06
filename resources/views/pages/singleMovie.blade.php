@php
    use Carbon\Carbon;
@endphp

@extends('layouts.no-sidebar')

@section('title', 'ReelzList')

@section('content')



@if(isset($movie))
    <div class="row justify-content-center">
        <div class="col text-center">
            <p>
                <h2>{{ $movie['title'] }}</h2>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <img src="{{ $movie['poster_url'] }}" alt="{{ $movie['title'] }} Poster" />
        </div>
        <div class="col-md-6">
            <p>
                {{ $movie['overview'] }}
            </p>
            <div>
                <p>
                    Released {{ \Carbon\Carbon::parse($movie['release_date'])->format('M d, Y') }}
                </p>
                <p>Rated <strong class="text-dark">{{ $movie['mpaa_rating'] }}</strong>
                </p>
            </div>
            <div class="col-md-6">
                <p>
                    Budget {{ $movie['budget'] }}<br />
                    Box Office {{ $movie['box_office'] }}
                </p>
            </div>
            <div class="col-md-6">
                IMDB Link <a href="https://www.imdb.com/title/{{ $movie['imdb_id'] }}/">{{ $movie['title'] }}</a>
            </div>
        </div>
    </div>
    <pre>
        <?php var_dump($movie) ?>
    </pre>
@endif

@endsection