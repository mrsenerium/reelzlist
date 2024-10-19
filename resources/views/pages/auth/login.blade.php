@php
    use Carbon\Carbon;
@endphp

@extends('layouts.no-sidebar')

@section('title', 'ReelzList - Login')

@section('content')

<div class="hundred-padding">
<div class="container d-flex align-items-center justify-content-center v-50">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title text-center">Login</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group class">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input required id="password" type="password" name="password" required class="form-control">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
            <p class="my-3">
                <a href="{{ route('registration.create') }}">Don't have a login Register</a>
            </p>
        </div>
    </div>
</div>

@endsection
