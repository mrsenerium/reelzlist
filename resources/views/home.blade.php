@extends('layouts.no-sidebar')

@section('title', 'ReelzList')

@section('content')

<div class="row">
    <p>If you're here then you know.  I do need to give a huge shout out to <a href="https://www.omdbapi.com">OMDb</a> and <a href="https://www.themoviedb.org">TMDb</a> and <a href="https://justwatch.com">JustWatch</a></p>
    <p>I'm making this with bootstrap <a href="https://bootswatch.com/lux/">Lux</a> from Bootswatch.
</div>
<div class="row">
    <p>This is where I'm going to keep a list of features to be built out</p>
    <ul>
        <li>Users</li>
        <li>User Profile</li>
        <li>Users List
            <ul>
                <li>Favorite</li>
                <li>Ownership</li>
                <li>Wish List to see</li>
                <li>Wish List to own</li>
            </ul>
        </li>
        <li>Users Reviews</li>
        <li>Where to watch <em>this exists but needs to be changed for Members Only</em></li>
    </ul>
</div>
<div class="row">
    <p>In the making of this App I watched:
        <ol>
            <li><a href="{{ '/movie/23478/tmdb' }}">Mozart and the Whale</a></li>
            <li><a href="{{ '/movie/536554/tmdb' }}">Megan</a></li>
            <li><a href="{{ '/movie/7443/tmdb' }}">Chicken Run</a></li>
            <li><a href="{{ '/movie/284674/tmdb' }}">Air</a></li>
            <li><a href="{{ '/movie/653601/tmdb' }}">Horse Girl</a></li>
            <li><a href="{{ '/movie/10692/tmdb' }}">Henry: Portrait of a Serial Killer</a></li>
            <li><a href="{{ '/movie/551804/tmdb' }}">Freaky</a></li>
        </ol>
    </p>
</div>

@endsection
