@extends('layouts.no-sidebar')

@section('title', 'ReelzList - Login')

@section('content')

<form method="POST" action="{{ route('movie-lists.store') }}">
    {{-- <label for="listName">List Name</label>
    <input type="text" name="listName">
    <{!! Form::submit($text, [$options]) !!} --}}
    <div class="container">
        <h2>Create a Movie List</h2>

        {!! Form::open(['route' => 'movie-lists.store', 'method' => 'post']) !!}

        <div class="form-group">
            {!! Form::label('name', 'Name:') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
        </div>

        {!! Form::submit('Create List', ['class' => 'btn btn-primary']) !!}

        {!! Form::close() !!}
    </div>

@endsection
