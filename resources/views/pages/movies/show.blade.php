@php
    use Carbon\Carbon;
@endphp

@extends('layouts.no-sidebar')

@section('title')
    {{ $movie['title'] }}
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
            <div class="col-md-3">
                <img src="{{ $movie['poster_url'] }}" alt="{{ $movie['title'] }} Poster" />
            </div>
            <div class="col-md-6">
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
                        Budget {{ $movie['budget'] }}<br />
                        Box Office {{ $movie['box_office'] }}
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
        <hr />
        <div class="row bg-dark text-white">
            @if (isset($watchProviders))
                <div class="col-md-6">
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
                <div class="col-md-6">
                    <p>No Streaming information available.</p>
                </div>
            @endif
            <div class="col-md-6">
                <p>For more information and rates please go to <a class="text-white" href="{{ isset($watchProviders->link) ? $watchProviders->link : 'https://www.themoviedb.org/' }}">The Movie Database</a></p>
                <p>All streaming infomation is provided by
                    <a href="https://justwatch.com/">
                        <img src="https://www.themoviedb.org/assets/2/v4/logos/justwatch-c2e58adf5809b6871db650fb74b43db2b8f3637fe3709262572553fa056d8d0a.svg" height="15"/>
                    </a>
                </p>
                <div class="card border-secondary mb-3" style="max-width: 35rem;">
                    <div class="card-header">Your Lists</div>
                    <div class="card-body">

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>List Name</th>
                                    <th>Add/remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($movieLists as $list)
                                    <tr>
                                        <td class="card-text">{{ $list->name }}</td>
                                        <td>
                                            @if (in_array($movie['id'], $list->movie->pluck('id')->toArray()))
                                            'true'
                                            @else
                                                <a href="{{ route('movie-lists.add', ['movieList' => $list, 'movie' => $movie['id']]) }}">
                                                    Add
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection