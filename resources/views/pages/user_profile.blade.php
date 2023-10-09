@php
    use Carbon\Carbon;
@endphp

@extends('layouts.no-sidebar')

<?php $title = isset($movie);?>
@if($title)
    @section('title', 'ReelzList ' . $movie['title'])
@else
    @section('title', 'ReelzList')
@endif

@section('content')

    @if(isset($profile))
        <div class="row justify-content-center">
            <div class="col text-center">
                <p>
                    <h2>{{ $profile->given_name . " " . $profile->family_name }}</h2>
                </p>
            </div>
        </div>
        <a href="{{ route('update.profile') }}">Update Profile</a>
        @if (isset($movie_lists))
            <div class="row">
                @foreach ($movie_lists as $list)
                    <div class="col-4">
                        {{ $list->name }} is @if ($list->private) Personal @else Public @endif
                    </div>
                @endforeach
            </div>
        @endif
        <pre>
            <?php $movie_lists;?>
        </pre>
    @endif

@endsection
