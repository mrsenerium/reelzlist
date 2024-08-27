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
        <li>Users</li>
            <ul class="alert alert-success">
                <li>Create Admin pages</li>
                <li>Create User Edit pages</li>
            </ul>
        <li>User Profile</li>
        <li class="alert alert-success">Users List - Done
            <ul>
                <li>Favorite</li>
                <li>Ownership</li>
                <li>Wish List to see</li>
                <li>Wish List to own</li>
            </ul>
        </li>
        <li class="alert alert-success">Feedback / help
            <ul>
                <li>Feature Request</li>
                <li>Bug Report</li>
                <li>General</li>
            </ul>
        </li>
        <li class="alert alert-success">Users Reviews
            <ul>
                <li>Draft</li>
                <li>Index</li>
                <li>Private</li>
            </ul>
        </li>
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
        <li>Notifications
            <ul>
                <li>Friend Request</li>
                <li>Recommendation</li>
                <li>Movie is on a Subscribed Platform</li>
                <li>Notification area</li>
                <li>Onsite only / Email</li>
            </ul>
        </li>
        <li>Subscriptions
            <ul>
                <li>Platform</li>
                <li>Users list of platforms</li>
                <li>Update lists to opt in for Notifications</li>
            </ul>
        </li>
    </ul>
</div>
<div class="row">
    <p><h4>In the making of this App I watched:</h4>
        <ol>
            <li><a href="{{ '/tmdb/23478' }}">Mozart and the Whale</a></li>
            <li><a href="{{ '/tmdb/536554' }}">Megan</a></li>
            <li><a href="{{ '/tmdb/7443' }}">Chicken Run</a></li>
            <li><a href="{{ '/tmdb/284674' }}">Air</a></li>
            <li><a href="{{ '/tmdb/653601' }}">Horse Girl</a></li>
            <li><a href="{{ '/tmdb/10692' }}">Henry: Portrait of a Serial Killer</a></li>
            <li><a href="{{ '/tmdb/18462' }}">Night of the Comet</a></li>
            <li><a href="{{ '/tmdb/12149' }}">Frailty</a></li>
            <li><a href="{{ '/tmdb/773' }}">Litte Miss Sunshine</a></li>
            <li><a href="{{ '/tmdb/19794' }}">Labor Pains</a></li>
            <li><a href="{{ '/tmdb/820609'}}">No One Will Save You</a></li>
            <li><a href="{{ '/tmdb/458305' }}">Vivarium</a></li>
            <li><a href="{{ '/tmdb/9966' }}">The Messengers</a></li>
        </ol>
    </p>
</div>

@endsection
