@php
    use Carbon\Carbon;
@endphp

@extends('layouts.no-sidebar')

@section('title', 'ReelzList - List')

@section('scripts')
<script>

    
    let showWatched = false;

    $(function () {
        $('.movie-item').each(function() {
            const isWatched = $(this).data('watched') === 1;
            if(!showWatched && isWatched) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    });

    $(document).on('click', '.watched-btn', function(e) {
        e.preventDefault();

        showWatched = !showWatched;
        $('.movie-item').each(function() {
            const isWatched = $(this).data('watched') === 1;

            if(!showWatched && isWatched) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });

        $(this).text(showWatched ? 'Hide Watched' : 'Show Watched');
    });
</script>
@endsection

@section('content')

<div class="row">
    <div class="col-9">
        <h3>{{ $movieList->name }}</h3>
    </div>
    <div class="col-3">
        <a href="{{ route('movie-lists.edit', ['movie_list' => $movieList->id]) }}" class="btn btn-info">Edit List Settings</a>
        <button id="toggle-watched" class="watched-btn btn btn-secondary">Show Watched</button>
    </div>
</div>

{{ $movieList->private ? 'Private' : 'Public' }} List
    <table class="table table-hover">
        <thead>
            <tr>
                <th></th>
                <th>Title</th>
                <th>Year</th>
                <th>Synopsis</th>
                <th>Actions</th>
                <th>Subscriptions</th>
                <th>Watched</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movies as $movie)
                <tr class="movie-item" data-watched="{{ $movie->pivot->watched }}">
                    <th scope="row">
                        @if (isset($movie->poster_url))
                            <a href="{{ route('movies.show', $movie->slug) }}">
                                <img src="{{ $movie->poster_url }}" style="max-height:75px" />
                            </a>
                        @endif
                    </th>
                    <th>
                        <a href="{{ route('movies.show', $movie->slug) }}">
                            {{ $movie->title }}
                        </a>
                    </th>
                    <td>
                        {{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}
                    </td>
                    <td>
                        {{ substr($movie->overview, 0, 200) }}
                    </td>
                    <td>
                        <form action="{{ route('movie-lists.movies.destroy', ['movie_list' => $movieList->id, 'movie' => $movie->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to remove this movie?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Remove</button>
                        </form>
                    </td>
                    <td>
                        @if ($movie->watch_providers)
                            @foreach ($movie->watch_providers as $provider)
                                <img 
                                src="https://www.themoviedb.org/t/p/original{{ $provider->logo_path }}" 
                                alt="{{ $provider->provider_name }}"
                                class="provider-logo mt-1"
                                width="30"
                                height="30"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="{{ $provider->provider_name }}"

                                />
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if ($movie->pivot->watched)
                            <span class="btn text-success ml-2" style="display: inline;">Watched</span>
                            <form action="{{ route('unwatchMovies') }}" method="POST" class="ml-2" style="display:inline;">
                                @csrf
                                <input type="hidden" name="movie_list_id" value="{{ $movieList->id }}" />
                                <input type="hidden" name="movie_id" value="{{ $movie['id'] }}" />
                                <button type="submit" class="btn"><span class="text-warning">Unwatch</span></button>
                            </form>
                        @else
                            <form action="{{ route('watchedMovies') }}" method="POST" class="ml-2" style="display:inline;">
                                @csrf
                                <input type="hidden" name="movie_list_id" value="{{ $movieList->id }}" />
                                <input type="hidden" name="movie_id" value="{{ $movie['id'] }}" />
                                <button type="submit" class="btn"><span class="text-info">Mark as Watched</span></button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('profile.show', [auth()->user()->id]) }}">Back to Profile</a>
</div>

@endsection
