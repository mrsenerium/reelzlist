@php
    use Carbon\Carbon;
@endphp

@extends('layouts.no-sidebar')

@section('title', 'ReelzList - List')

@section('content')

{{ $movieList->name }} is a {{ $movieList->private ? 'Private' : 'Public' }} List
<div class="container">
    @foreach ($movies as $movie)
        <a href="{{route('pages.singleMovie', $movie->id)}}">{{$movie->title}}</a>
    @endforeach
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Title</th>
                <th>Year</th>
                <th>Synopsis</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movies as $movie)
                <tr>
                    <th scope="row"><a href="{{route('pages.singleMovie', $movie->id)}}">{{$movie->title}}</a></th>
                    <td>{{\Carbon\Carbon::parse($movie->release_date)->format('Y')}}</td>
                    <td>{{substr($movie->overview, 0, 200)}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
