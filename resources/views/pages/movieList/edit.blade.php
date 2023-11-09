@extends('layouts.no-sidebar')

@section('title', 'ReelzList - Login')

@section('content')

<div class="container">
    <h2>{{ $movieList->name }}</h2>

    {!! Form::model($movieList, ['route' => ['movie-lists.update', 'movie_list' => $movieList->id], 'method' => 'put']) !!}
    {{ csrf_field() }}

    <div class="form-group row">
        <div class="col-6">
            {!! Form::label('name', 'Name:') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
        </div>
        <div class="col-6">
            {!! Form::label('private', 'Private') !!}
            {!! Form::checkbox('private', 1, $movieList->private, ['class' => 'form-check-input']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-3 mt-2">
            {!! Form::submit('Update List', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>

    {!! Form::close() !!}

    {{-- Delete Movie List Form --}}
    <form method="POST" action="{{ route('movie-lists.destroy', ['movie_list' => $movieList->id]) }}" onsubmit="return confirm('Are you sure you want to delete this list?')" class="mt-2 form-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Movie List</button>
    </form>

</div>

@endsection
