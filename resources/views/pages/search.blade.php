@php
    use Carbon\Carbon;
@endphp

@extends('layouts.no-sidebar')

@section('title', 'ReelzList')

@section('content')

<div class="row">
    <p>I need to put a search box and start searching proper!</p>

    <form class="d-flex" method="post" action="/search">
        @csrf
        {{ method_field('POST') }}
        <input name="search" class="form-control me-sm-2" type="search" {{ isset($search) ? 'value='.$search : 'placeholder=Search' }}>
        <button class="btn btn-primary my-2 my-sm-0" type="submit">Search</button>
      </form>
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