@extends('layouts.no-sidebar')

@section('title', 'ReelzList - What should I watch?')

@section('content')

<div class="row">
    <div class="col">
        <h3>What should I watch?</h3>
    </div>
</div>

<div>
    <form method="GET" action="{{ route('what-to-watch') }}" class="mt-2 mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="genre" class="form-label">Genre</label>
                    <select name="genre" id="genre" class="form-select">
                        <option value="">All Genres</option>
                        @foreach ($genreList as $genre)
                            <option
                                value="{{ $genre->name }}"
                                @if ($genre->name === request('genre'))
                                    selected="selected"
                                @endif
                            >
                                {{ $genre->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="year" class="form-label">Year</label>
                    <input
                        type="text"
                        name="year"
                        id="year"
                        class="form-control"
                        value="{{ request('year') }}"
                    >
                </div>
                <div class="col-md-2">
                    <input type="hidden" name="hideWatched" value="0">
                    <div class="form-check mb-2">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="hideWatched"
                            id="hideWatched"
                            value="1"
                            @checked(request()->boolean('hideWatched', true))
                        >
                        <label class="form-check-label" for="hideWatched">
                            Hide Watched
                        </label>
                    </div>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">
                        {{ $movies->isNotEmpty() ? 'Suggest again' : 'Suggest' }}
                    </button>
                </div>
            </div>
            @if ($errors->any())
                <div class="text-danger mt-3">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
        </div>
    </form>
</div>

@if ($movies->isEmpty())
    <p>Nothing matches those filters.</p>
    @unless ($hasLists)
        <a href="{{ route('movie-lists.create') }}">Create a movie list</a>
    @endunless
@else
   <div class="mt-4 row">
       @foreach($movies as $movie)
           <div class="col-4 text-center">
               <a href="{{ route('movies.show', $movie->slug) }}">
                   <img
                       src="{{ $movie->poster_url }}"
                       alt="{{ $movie->title }}"
                       class="img-fluid"
                   />
                   <p class="mt-2">
                       {{ $movie->title }}
                   </p>
               </a>
           </div>
       @endforeach
   </div>
@endif

@auth
    <div class="mt-4 mb-4">
        <a href="{{ route('profile.show', [auth()->user()->id]) }}">Back to Profile</a>
    </div>
@endauth

@endsection
