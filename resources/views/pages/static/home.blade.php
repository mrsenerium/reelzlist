@extends('layouts.no-sidebar')

@section('title')
    Home
@endSection

@section('content')

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
    <div class="row text-center">
        <h2>Reelz List</h2>
        <p>Reelz List is a place to keep track of the movies you want to see, the movies you own, and the movies you've seen.</p>
        <p>It's a place to keep track of your reviews and share them with your friends.</p>
        <p>This site is still in alpha, so please be patient with me. Upcoming <a href="{{ route('features') }}">Features</a></p>
    </div>

    <div class="row">
        @foreach ($movies as $movie)
            <div class="col-md-2">
                <a href="{{ route('movies.show', $movie['slug']) }}">
                    <div class="card mb-4 shadow-sm">
                        <img src="{{ $movie['poster_url'] }}" class="card-img-top" alt="{{ $movie['title'] }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $movie['title'] }}</h5>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

@endsection
