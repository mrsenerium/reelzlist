@php
    use Carbon\Carbon;
@endphp

@extends('layouts.no-sidebar')

@section('title', 'ReelzList - List')

@section('content')

<h3>{{ $movieList->name }}</h3>
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
                        <a href="{{ route('pages.singleMovie', $movie->id) }}">
                            @if (isset($movie->poster_url))
                                <img src="{{ $movie->poster_url }}" style="max-height:75px" />
                            @endif
                        </a>
                    </th>
                    <th><a href="{{ route('pages.singleMovie', $movie->id) }}">{{ $movie->title }}</a></th>
                    <td>{{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}</td>
                    <td>{{ substr($movie->overview, 0, 200) }}</td>
                    <td><a href="{{ route('movie-lists.remove', ['movieList' => $movieList->id, 'movie' => $movie->id]) }}">Remove</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
