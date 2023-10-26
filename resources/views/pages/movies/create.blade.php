@extends('layouts.no-sidebar')

@section('title')
    Add a Movie
@endsection

@section('content')
    <div class="row">
        <form class="d-flex" method="post" action="{{ route('movies.store') }}">
            @csrf

            <input
                name="id"
                class="form-control me-sm-2"
                type="search"
                placeholder="IMDB ID / TMDB ID"
            >

            <button class="btn btn-primary my-2 my-sm-0" type="submit">
                Add Movie
            </button>
        </form>
    </div>
@endsection
