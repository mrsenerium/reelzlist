@php
    use Carbon\Carbon;
@endphp

@extends('layouts.no-sidebar')

@section('title', 'ReelzList - List')

@section('content')

<div class="row">
    <div class="col-9">
        <h3>{{ $movieList->name }}</h3>
    </div>
    <div class="col-3">
        <a href="{{ route('movie-lists.edit', ['movie_list' => $movieList->id]) }}" class="btn btn-info">Edit List Settings</a>
    </div>
</div>

{{ $movieList->private ? 'Private' : 'Public' }} List

@can('edit', $movieList)
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="hide-watched-toggle" checked />
        <label class="form-check-label" for="hide-watched-toggle">Hide watched movies</label>
    </div>
@endcan

    <table class="table table-hover" id="movie-list-table">
        <thead>
            <tr>
                <th></th>
                <th>Title</th>
                <th>Year</th>
                <th>Synopsis</th>
                <th>Actions</th>
                <th>Subscriptions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movies as $movie)
                <tr
                    @can('edit', $movieList)
                        data-list-movie-row
                        data-is-watched="{{ $movie->pivot->is_watched ? '1' : '0' }}"
                    @endcan
                    @class(['table-secondary' => auth()->user()?->can('edit', $movieList) && $movie->pivot->is_watched])
                >
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
                        <small class="d-block">
                            @foreach ($movie->genres as $genre)
                                <br /><span>{{ $genre->name }}</span>
                            @endforeach
                        </small>
                    </th>
                    <td>
                        {{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}
                    </td>
                    <td>
                        {{ substr($movie->overview, 0, 200) }}
                    </td>
                    <td>
                        @can('edit', $movieList)
                            <div class="d-flex flex-wrap align-items-center gap-1">
                                <form action="{{ route('movie-lists.movies.update', ['movie_list' => $movieList->id, 'movie' => $movie->slug]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="is_watched" value="{{ $movie->pivot->is_watched ? '0' : '1' }}" />
                                    <button type="submit" class="btn btn-sm {{ $movie->pivot->is_watched ? 'btn-outline-secondary' : 'btn-primary' }}">
                                        {{ $movie->pivot->is_watched ? 'Unwatch' : 'Mark Watch' }}
                                    </button>
                                </form>
                                <form action="{{ route('movie-lists.movies.destroy', ['movie_list' => $movieList->id, 'movie' => $movie->slug]) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this movie?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </div>
                        @endcan
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
                </tr>
            @endforeach
        </tbody>
    </table>
    @auth
        <a href="{{ route('profile.show', [auth()->user()->id]) }}">Back to Profile</a>
    @endauth
</div>

@endsection

@can('edit', $movieList)
    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var toggle = document.getElementById('hide-watched-toggle');
                if (!toggle) {
                    return;
                }
                var apply = function () {
                    var hide = toggle.checked;
                    document.querySelectorAll('[data-list-movie-row]').forEach(function (row) {
                        var watched = row.getAttribute('data-is-watched') === '1';
                        row.style.display = hide && watched ? 'none' : '';
                    });
                };
                toggle.addEventListener('change', apply);
                apply();
            });
        </script>
    @endsection
@endcan
