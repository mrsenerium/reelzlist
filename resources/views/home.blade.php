@extends('layouts.no-sidebar')

@section('title')
    Home
@endSection

@section('content')

<div class="row">
    <p>If you're here then you know.  I do need to give a huge shout out to <a href="https://www.omdbapi.com">OMDb</a> and <a href="https://www.themoviedb.org">TMDb</a> and <a href="https://justwatch.com">JustWatch</a></p>
    <p>I'm making this with bootstrap <a href="https://bootswatch.com/lux/">Lux</a> from Bootswatch.
</div>
<div class="row">
    <p>This is where I'm going to keep a list of features to be built out</p>
    <ul>
        <li>Users <em>This needs to be built up more with auth levels</em></li>
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
        <li>Friends
            <ul>
                <li>Recommendations</li>
                <li>Private Reviews</li>
            </ul>
        </li>
        <li class="alert alert-success">Where to watch <em>this exists for Members Only</em></li>
        <li>Movies
            <ul>
                <li>Search</li>
                    <ul><li>Genre Filter</li></ul>
                <li>Movie Page</li>
                <li>Trailers</li>
            </ul>
        </li>
    </ul>
</div>
<div class="row">
    <p>In the making of this App I watched:
        <ol>
            <li><a href="{{ '/tmdb/23478' }}">Mozart and the Whale</a></li>
            <li><a href="{{ '/tmdb/536554' }}">Megan</a></li>
            <li><a href="{{ '/tmdb/7443' }}">Chicken Run</a></li>
            <li><a href="{{ '/tmdb/284674' }}">Air</a></li>
            <li><a href="{{ '/tmdb/653601' }}">Horse Girl</a></li>
            <li><a href="{{ '/tmdb/10692' }}">Henry: Portrait of a Serial Killer</a></li>
            <li><a href="{{ '/tmdb/18462' }}">Night of the Comet</a></li>
            <li><a href="{{ '/tmdb/12149' }}">Frailty</a></li>
        </ol>
    </p>
</div>

@endsection
