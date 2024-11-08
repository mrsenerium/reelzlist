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
                <a href="{{ route('subscriptions.index') }}" class="btn btn-info w-100">Manage your subscriptions</a>
            </div>
        </div>
        <div class="row">
            <div class="col-7">
                <h3>Your Subscriptions</h3>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Provider</th>
                                <th scope="col">Logo</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscriptions as $subscription)
                                <tr>
                                    <td>{{ $subscription->name }}</td>
                                    <td>
                                        <img 
                                            src="https://www.themoviedb.org/t/p/original{{ $subscription->url }}" 
                                            alt="{{ $subscription->name }}"
                                            class="provider-logo"
                                            width="50"
                                            height="50"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="{{ $subscription->name }}"
                                        >
                                    </td>
                                    <td>
                                        <form action="{{ route('subscriptions.destroy', $subscription->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

@endsection
