@extends('layouts.no-sidebar')

@section('title', 'ReelzList - Users')

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
    <div class="container">
        <h2>User Administration</h2>
        <div class="row">
            <div class="col-4">
                <strong>Name: </strong>{{ $user->name }}
            </div>
            <div class="col-4">
                <strong>Email: </strong>{{ $user->email }}
            </div>
            <div class="col-4">
                <strong>Role: </strong>{{ $user->role }}
            </div>
            <p>Need the lists from user</p>
            <p>Need the reviews</p>
        </div>
        <div class="row">
            @if(isset($movieLists))
                <div class="card border-secondary mb-3 scrollable-box">
                    @foreach($movieLists as $list)
                        <div class="movie-list-item">
                            <span><a href="{{ route('movie-lists.show', ['movie_list' => $list->id]) }}">{{ $list->name }}</a></span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="row">
            @foreach ($reviews as $review)
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
        </div>
    </div>

@endsection
