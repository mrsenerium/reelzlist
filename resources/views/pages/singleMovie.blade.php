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
                <p>
                    IMDB Link <a href="https://www.imdb.com/title/{{ $movie['imdb_id'] }}/">{{ $movie['title'] }}</a>
                </p>
            </div>
            <div class="row">
                <div class="col-md-3">
                    Rotten Tomatoes {{ $movie['tomatometer'] }}
                </div>
                <div class="col-md-3">
                    IMDB Rating {{ $movie['imdb_rating'] }}
                </div>
                <div class="col-md-3">
                    Metacritic {{ $movie['metacritic_rating'] }}
                </div>
                <div class="col-md-3">
                    tmdb_id = {{ $movie['tmdb_id'] }}
                </div>
            </div>
        </div>
    </div>
    @if(isset($watchProviders))
        <div class="row">
            <p>For more information and rates please go to <a href="{{ $watchProviders->link }}">The Movie Database</a></p>
            <p>All streaming infomation is provided by
                <a href="https://justwatch.com">
                    <img src="https://www.themoviedb.org/assets/2/v4/logos/justwatch-c2e58adf5809b6871db650fb74b43db2b8f3637fe3709262572553fa056d8d0a.svg" height="15"/>
                </a>
            </p>
            @if(isset($watchProviders->buy))
                <div class="col-lg-4">
                    @foreach($watchProviders->buy as $provider)
                        {{ 'bob' }}
                    @endforeach
                </div>
            @endif
            @if (isset($watchProviders->flatrate))
                <div class="col-lg-4"></div>
            @endif
            <div class="col-lg-4"></div>
        </div>
    @endif
@endif

@endsection
