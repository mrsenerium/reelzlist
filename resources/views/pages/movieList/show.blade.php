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
    <table class="table table-hover">
        <thead>
            <tr>
                <th></th>
                <th>Title</th>
                <th>Year</th>
                <th>Synopsis</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movies as $movie)
                <tr>
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
                        <a href="{{ route('movie-lists.remove', ['movieList' => $movieList->id, 'movie' => $movie->id]) }}" onclick="return confirm('Are you sure you want to remove this movie?')">
                            Remove
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('profile.show', [auth()->user()->id]) }}">Back to Profile</a>
</div>

@endsection
