@php
    use Carbon\Carbon;
@endphp

@extends('layouts.no-sidebar')

@section('title')
    People Search
@endsection

@section('content')

    <div class="row">
        <form class="d-flex" method="get" action="{{ route('public-profiles.index') }}">
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

{{--        @foreach($profiles as $profile)--}}
{{--            <p>{{$profile->given_name}} {{$profile->family_name}}</p>--}}
{{--        @endforeach--}}

        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">username</th>
                <th scope="col">Link</th>
            </tr>
            </thead>
            <tbody>
            @foreach($profiles as $key => $profile)
                @if (is_numeric($key) && $key % 2)
                    <tr class="table-primary">
                        <td>{{$profile->given_name}} {{$profile->family_name}}</td>
                        <td>{{ $profile->username }}</td>
                        <td><a href=" route('public-profiles.show', $profile->id) ">See Profile</a></td>
                    </tr>
                @else
                    <tr class="table-secondary">
                        <td>{{$profile->given_name}} {{$profile->family_name}}</td>
                        <td>{{ $profile->username }}</td>
                        <td><a href=" route('public-profiles.show', $profile->id) ">See Profile</a></td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
