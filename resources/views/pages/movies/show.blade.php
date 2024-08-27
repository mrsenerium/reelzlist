@php
    use Carbon\Carbon;
@endphp

@extends('layouts.no-sidebar')

@section('title')
    {{ $movie['title'] }}
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="{{ asset('js/showStars.js') }}" type="text/javascript"></script>
    <style>
        /* Define a fixed height for the scrollable box */
        .scrollable-box {
            max-height: 300px; /* Adjust the height as needed */
            overflow-y: auto; /* Enable vertical scrolling */
            border: 1px solid #ccc; /* Optional: Add a border for styling */
        }

        /* Optional: Style for each movie list item */
        .movie-list-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
    </style>
    <style>
        .movie-list-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* padding: 10px; */
            /* border: 1px solid #ccc;
            margin-bottom: 10px; */
        }

        .button-container {
            display: flex;
            gap: 10px; /* Adjust the gap between buttons */
        }

        .success-button {
            flex-grow: 1; /* Make the success div take the available space */
            text-align: center;
            background-color: #28a745;
            color: #fff;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        .add-button {
            text-align: center;
            background-color: #17a2b8;
            color: #fff;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
@endsection

@section('content')
    @if (isset($movie))
        <div class="row justify-content-center">
            <div class="col text-center">
                <p>
                    <h2>{{ $movie['title'] }}</h2>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 overflow-auto">
                <img src="{{ $movie['poster_url'] }}" alt="{{ $movie['title'] }} Poster" />
            </div>
            <div class="col-md-6 overflow-auto">
                <p>
                    {{ $movie['overview'] }}
                </p>
                <div>
                    <p>
                        {{ $movie['runtime'] }} Minutes
                    </p>
                    <p>
                        Released {{ \Carbon\Carbon::parse($movie['release_date'])->format('M d, Y') }}
                    </p>
                    <p>Rated <strong class="text-dark">{{ $movie['mpaa_rating'] }}</strong>
                    </p>
                </div>
                <div class="col-md-6">
                    <p>
                        Budget ${{ number_format($movie['budget'], 0, '.', ',') }}<br />
                        Box Office ${{ number_format($movie['box_office'], 0, '.', ',') }}
                    </p>
                    <p>
                        IMDB Link <a href="https://www.imdb.com/title/{{ $movie['imdb_id'] }}/">{{ $movie['title'] }}</a>
                    </p>
                </div>
                <div class="row">
                    @if (isset($movie['tomatometer']))
                    <div class="col-md-3">
                        Rotten Tomatoes {{ $movie['tomatometer'] }}
                    </div>
                    @endif
                    @if (isset($movie['imdb_rating']))
                    <div class="col-md-3">
                        IMDB Rating {{ $movie['imdb_rating'] }}
                    </div>
                    @endif
                    @if (isset($movie['metacritic_rating']))
                    <div class="col-md-3">
                        Metacritic {{ $movie['metacritic_rating'] }}
                    </div>
                    @endif
                    <div class="col-md-3">
                        TMDb id={{ $movie['tmdb_id'] }}
                    </div>
                </div>
            </div>
        </div>
        @if(Auth::user())
            <hr />
            <div class="row bg-dark text-white">
                <div class="row">
                    <div class="col-md-6">
                        @if (isset($watchProviders))
                            <div class="">
                                @if (isset($watchProviders->flatrate))
                                    @include('partials/_streaming_providers', ['title' => 'Streaming Subscription', 'providers' => $watchProviders->flatrate])
                                @endif
                                @if (isset($watchProviders->buy))
                                    @include('partials/_streaming_providers', ['title' => 'Streaming Purchase', 'providers' => $watchProviders->buy])
                                @endif
                                @if (isset($watchProviders->rent))
                                    @include('partials._streaming_providers', ['title' => 'Streaming Rent', 'providers' => $watchProviders->rent])
                                @endif
                                @if (isset($watchProviders->ads))
                                    @include('partials._streaming_providers', ['title' => 'Available with Ads', 'providers' => $watchProviders->ads])
                                @endif
                                @if (isset($watchProviders->free))
                                    @include('partials._streaming_providers', ['title' => 'Available For Free', 'providers' => $watchProviders->free])
                                @endif
                            </div>
                        @else
                            <div >
                                <p>No Streaming information available.</p>
                            </div>
                        @endif
                        <br />
                        @if (isset($review))
                            <div >
                                <div class="col-6 mb-2">
                                <span class="fa fa-star star" data-rating=1></span>
                                <span class="fa fa-star star" data-rating=2></span>
                                <span class="fa fa-star star" data-rating=3></span>
                                <span class="fa fa-star star" data-rating=4></span>
                                <span class="fa fa-star star" data-rating=5></span>
                                {!! Form::hidden('rating', $review->rating, ['id' => 'selected-rating']) !!}
                            </div>
                                <h5 class="text-white">{{ $review->name }}</h5>
                                <p>{{ Illuminate\Support\Str::limit($review->body, 200, '...') }}</p>
                                <a class="text-white" href="{{ route('review.show', ['review' => $review]) }}">Read Full Review</a>
                            </div>
                        @else
                            <div >
                                <a class="text-white" href="{{ route('review.create', ['user_id' => auth()->user()->id, 'movie_id' => $movie['id']]) }}">
                                    Write a review
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <p>For more information and rates please go to <a class="text-white" href="{{ isset($watchProviders->link) ? $watchProviders->link : 'https://www.themoviedb.org/' }}">The Movie Database</a></p>
                        <p>All streaming infomation is provided by
                            <a href="https://justwatch.com/">
                                <img src="https://www.themoviedb.org/assets/2/v4/logos/justwatch-c2e58adf5809b6871db650fb74b43db2b8f3637fe3709262572553fa056d8d0a.svg" height="15"/>
                            </a>
                        </p>
                        @if(isset($movieLists))
                            <div class="card border-secondary mb-3 scrollable-box">
                                @foreach($movieLists as $list)
                                    <div class="movie-list-item">
                                        <span><a href="{{ route('movie-lists.show', ['movie_list' => $list->id]) }}">{{ $list->name }}</a></span>
                                        <div class="button-container">
                                            @if (in_array($movie['id'], $list->movie->pluck('id')->toArray()))
                                                <div class="success-button">
                                                    On List
                                                </div>
                                            @else
                                                <form action="{{ route('movie-lists.movies.store', ['movie_list' => $list->id]) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="movie_id" value="{{ $movie['id'] }}" />
                                                    <button type="submit" class="add-button">Add to list</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    @endif
    @foreach ($otherReviews as $review)
        <hr />
        <div class="container">
            <div class="row mt-3">
                <div>
                    <div class="col-6 mb-2">
                    <span class="fa fa-star star" data-rating=1></span>
                    <span class="fa fa-star star" data-rating=2></span>
                    <span class="fa fa-star star" data-rating=3></span>
                    <span class="fa fa-star star" data-rating=4></span>
                    <span class="fa fa-star star" data-rating=5></span>
                    {!! Form::hidden('rating', $review->rating, ['id' => 'selected-rating']) !!}
                </div>
                    <h5>{{ $review->name }}</h5>
                    <p>{{ Illuminate\Support\Str::limit($review->body, 200, '...') }}</p>
                    <a href="{{ route('review.show', ['review' => $review]) }}">Read Full Review</a>
                </div>
            </div>
        </div>
    @endforeach
    {{ $otherReviews->links() }}

@endsection
