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
        <pre>
            <?php var_dump($profile);?>
        </pre>
    @endif

@endsection
