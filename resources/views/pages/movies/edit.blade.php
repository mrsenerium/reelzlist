@extends('layouts.no-sidebar')

@section('title', 'ReelzList - New Review')

@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@endsection

@section('content')
    <div class="container">
        @if (!$movie->deleted_at == null)
            <h1 class="text-danger strong">DELETED</h1>
        @endif
        <h3>Edit Movie: {{$movie->title}}</h3>

        {!! Form::model($movie, ['route' => ['movies.update', 'movie' => $movie->slug], 'method' => 'put']) !!}
        {{ csrf_field() }}

        <div class="form-group row">
            <div class="col-6">
                {!! Form::label('title', 'Title:') !!}
                {!! Form::text('title', $movie->title, ['class' => 'form-control']) !!}
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <!! -- imdb_id, overview, runtime, poster_url, tmdb_id, budget, box_office, frontpage_safe -- !!>
        <div class="form-group row">
            <div class="col-6">
                {!! Form::label('imdb_id', 'IMDB ID:') !!}
                {!! Form::text('imdb_id', $movie->imdb_id, ['class' => 'form-control']) !!}
                @error('imdb_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-6">
                {!! Form::label('tmdb_id', 'TMDB ID:') !!}
                {!! Form::text('tmdb_id', $movie->tmdb_id, ['class' => 'form-control']) !!}
                @error('tmdb_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {!! Form::label('overview', 'Overview:') !!}
                {!! Form::textarea('overview', $movie->overview, ['class' => 'form-control', 'rows' => 4]) !!}
                @error('overview')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group row mt-2">
            <div class="col-4">
                {!! Form::label('runtime', 'Runtime (minutes):') !!}
                {!! Form::number('runtime', $movie->runtime, ['class' => 'form-control']) !!}
                @error('runtime')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-4">
                {!! Form::label('budget', 'Budget ($):') !!}
                {!! Form::number('budget', $movie->budget, ['class' => 'form-control']) !!}
                @error('budget')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-4">
                {!! Form::label('box_office', 'Box Office ($):') !!}
                {!! Form::number('box_office', $movie->box_office, ['class' => 'form-control']) !!}
                @error('box_office')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group row mt-2">
            <div class="col-12">
                {!! Form::label('poster_url', 'Poster URL:') !!}
                {!! Form::text('poster_url', $movie->poster_url, ['class' => 'form-control']) !!}
                @error('poster_url')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group row mt-2">
            <div class="col-6">
                <div class="form-check  mt-2">
                    {!! Form::checkbox('frontpage_safe', 1, $movie->frontpage_safe, ['class' => 'form-check-input', 'id' => 'frontpage_safe']) !!}
                    {!! Form::label('frontpage_safe', 'Frontpage Safe', ['class' => 'form-check-label']) !!}
                </div>
                @error('frontpage_safe')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-6 mt-2">
                {!! Form::submit('Update Movie', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('movies.show', ['movie' => $movie]) }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
        {!! Form::close() !!}
        @if (!$movie->deleted_at == null)
            <div class="row mt-4">
                <div class="col-6">
                    {!! Form::open(['route' => ['movies.restore', 'movie' => $movie->slug], 'method' => 'post']) !!}
                    {{ csrf_field() }}
                    {!! Form::submit('Restore Movie', ['class' => 'btn btn-success']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        @else
            <div class="row mt-4">
                <div class="col-6">
                    {!! Form::open(['route' => ['movies.destroy', 'movie' => $movie->slug], 'method' => 'delete']) !!}
                    {{ csrf_field() }}
                    {!! Form::submit('Delete Movie', ['class' => 'btn btn-danger', 'onclick' => "return confirm('Are you sure you want to delete this movie?')"]) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        @endif
    </div>

@endsection
