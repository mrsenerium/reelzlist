@extends('layouts.no-sidebar')

@section('title', 'Public Profiles')

@section('content')
    <pre>
        {{ $profiles }}
    </pre>
    <div class="container">
        <h1>Public Profiles</h1>
        @foreach ($profiles as $profile)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $profile->given_name }} {{ $profile->family_name }}</h5>
                </div>
            </div>
        @endforeach
    </div>
@endsection