@php
    use Carbon\Carbon;
@endphp

@extends('layouts.no-sidebar')

<?php $title = isset($movie);?>
@if ($title)
    @section('title', 'ReelzList ' . $movie['title'])
@else
    @section('title', 'ReelzList')
@endif

@section('content')

    @if (isset($profile))
        <div class="row justify-content-center">
            <div class="col text-center">
                <p>
                    <h2>{{ $profile->given_name . " " . $profile->family_name }}</h2>
                </p>
            </div>
        </div>
        <div class="row">
            <div class=col-9>
                @if (isset($movie_lists))
                    @foreach ($movie_lists as $list)
                        <p>
                            <a href={{ route('movie-lists.show', $list->id) }}>{{ $list->name }}</a> is @if ($list->private) Personal @else Public @endif
                        </p>
                    @endforeach
                @endif
            </div>
            <div class="col-3">
                <a class="btn w-100 btn-info mb-2" href="{{ route('profile.edit', [$profile->id]) }}">Update Profile</a>
                <a class="btn w-100 btn-info mb-2" href="{{ route('movie-lists.create') }}">Create Movie List</a>
                @can('view', $user)
                    <a class="btn w-100 btn-success mb-2" href="{{ route('users.index') }}">User Administration</a>
                @endcan
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <a href="{{ route('subscriptions.index') }}" class="btn btn-info w-100">Manage your subscriptions</a>
            </div>
        </div>
    @endif

@endsection
