@extends('layouts.no-sidebar')

@section('title', 'ReelzList - Edit Profile')

@section('content')

<div class="hundred-padding">
    <div class="container align-items-center justify-content-center">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Profile</h2>
                <form action="{{ route('profile.update', [$profile]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{$profile->user_id}}" />

                    <div class="mb-3 row">
                        <label for="given_name" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>

                        <div class="col-md-6">
                            <input id="given_name" type="text" class="form-control @error('given_name') is-invalid @enderror" name="given_name" value="{{ $profile->given_name }}" autocomplete="given_name" autofocus>

                            @error('given_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="family_name" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>

                        <div class="col-md-6">
                            <input id="family_name" type="text" class="form-control @error('family_name') is-invalid @enderror" name="family_name" value="{{ $profile->family_name }}" autocomplete="family_name">

                            @error('family_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="birthdate" class="col-md-4 col-form-label text-md-end">{{ __('Birthday') }}</label>

                        <div class="col-md-6">
                            <input id="birthdate" type="date" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate" value="{{ $profile->birthdate }}" autocomplete="birthdate">

                            @error('birthdate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>













{{-- <div class="hundred-padding">
<div class="container align-items-center justify-content-center ">
    <div class="">
        <div class="">
            <h2 class="card-title">profile</h2>
            <form action="{{ route('profile.update', [$profile]) }}" method="put">
                @csrf
                <div class="row mb-3 mt-3">
                    <label for="given_name" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>

                    <div class="col-md-6">
                        <input id="given_name" type="text" class="form-control @error('given_name') is-invalid @enderror" name="given_name" value="{{ $profile->given_name }}" autocomplete="given_name" autofocus>

                        @error('given_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="family_name" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>

                    <div class="col-md-6">
                        <input id="family_name" type="family_name" class="form-control @error('family_name') is-invalid @enderror" name="family_name" value="{{ $profile->family_name }}" autocomplete="family_name">

                        @error('family_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <em>Create a date picker for birthday</em>
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Save') }}
                        </button>
                    </div>
                </div>
                </form>
        </div>
    </div>
</div> --}}

@endsection
