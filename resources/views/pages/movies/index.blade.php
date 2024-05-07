@php
    use Carbon\Carbon;
@endphp

@extends('layouts.no-sidebar')

@section('title')
    Movies Search
@endsection

@section('content')

<div class="row">
    <form class="d-flex" method="get" action="{{ route('movies.index') }}">
        @csrf
        <input
            name="q"
            class="form-control me-sm-2"
            type="search"
            placeholder="Search"
            value="{{ $q ?? request()->input('q') }}"
        >
        <button class="btn btn-primary my-2 my-sm-0" type="submit">
            Search
        </button>
      </form>
</div>

<div class="row mt-3 mx-1">
    <form class="d-flex" method="get" action="{{ route('tmdb.index') }}">
        @csrf
        <input
            name="q"
            class="hidden"
            type="hidden"
            placeholder="Search"
            value="{{ $q ?? request()->input('q') }}"
        >
        <button class="btn btn-primary my-2 my-sm-0" type="submit">
            Can't Find it here, Try our external Database
        </button>
      </form>
    </a>
</div>

@if (isset($movies))
    <table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Synopsis</th>
            <th scope="col">Release Date</th>
        </tr>
    </thead>
        <tbody>
            @foreach ($movies as $key => $movie)
                @if (is_numeric($key) && $key % 2)
                    <tr
                        class="table-primary"
                        onclick="window.location='{{ route('movies.show', $movie['slug']) }}';" style="cursor: pointer;"
                    >
                        <th scope="row">{{ $movie['title'] }}</th>
                        <td>{{ $movie['overview'] }}</td>
                        @if(!empty($movie['release_date']))
                            <td class="wider-column">{{ \Carbon\Carbon::parse($movie['release_date'])->format('M d, Y') }}</td>
                        @else
                            <td class="wider-column">N/A</td>
                        @endif
                    </tr>
                @else
                    <tr class="table-secondary" onclick="window.location='{{ route('movies.show', $movie['slug']) }}';" style="cursor: pointer;">
                        <th scope="row">{{ $movie['title'] }}</th>
                        <td>{{ $movie['overview'] }}</td>
                        <td class="wider-column">{{ \Carbon\Carbon::parse($movie['release_date'])->format('M d, Y') }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table> 
    {{ $movies->links() }}
@endif

@endsection
