@php
    use Carbon\Carbon;
@endphp

@extends('layouts.no-sidebar')

@section('title', 'ReelzList')

@section('content')

<div class="row">
    <p>If you're here then you know.  I do need to give a huge shout out to <a href="https://www.omdbapi.com">OMDb</a> and <a href="https://www.themoviedb.org">TMDb</a> and JustWatch</p>
    <p>I'm making this with bootstrap <a href="https://bootswatch.com/lux/">Lux</a> from Bootswatch.
</div>
<div class="row">
    <p>This is where I'm going to keep a list of features to be built out</p>
    <ul>
        <li>Users</li>
        <li>User Profile</li>
        <li><ul>Users List
                <li>Favorite</li>
                <li>Ownership</li>
                <li>Wish List to see</li>
                <li>Wish List to own</li>
            </ul>
        </li>
        <li>Users Reviews</li>
        <li>Where to watch</li>
    </ul>
</div>
<div class="row">
    <p>In the making of this App I watched:
        <ol>
            <li>Mozart and the Whale</li>
            <li>Megan</li>
            <li>Chicken Run</li>
        </ol>
    </p>
</div>

@if(isset($movies))
    <table class="table table-hover">
    <thead>
        <tr>
        <th scope="col">Title</th>
        <th scope="col">Synopsis</th>
        <th scope="col">Release Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($movies as $key => $movie)
            @if(is_numeric($key) && $key % 2)
                <tr class="table-primary" onclick="window.location='/movie/{{$movie['id']}}';" style="cursor: pointer;">
                    <th scope="row">{{ $movie['title'] }}</th>
                    <td>{{ $movie['overview'] }}</td>
                    <td class="wider-column">{{ \Carbon\Carbon::parse($movie['release_date'])->format('M d, Y') }}</td>
                </tr>
            @else
                <tr class="table-secondary" onclick="window.location='/movie/{{$movie['id']}}';" style="cursor: pointer;">
                    <th scope="row">{{ $movie['title'] }}</th>
                    <td>{{ $movie['overview'] }}</td>
                    <td class="wider-column">{{ \Carbon\Carbon::parse($movie['release_date'])->format('M d, Y') }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
    </table>
@endif

@endsection