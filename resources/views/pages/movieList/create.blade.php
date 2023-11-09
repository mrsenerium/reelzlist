@extends('layouts.no-sidebar')

@section('title', 'ReelzList - Login')

@section('content')
    <div class="container">
        <h2>Create a Movie List</h2>
        {!! Form::open(['route' => 'movie-lists.store', 'method' => 'post']) !!}
        {{ csrf_field() }}
        <div class="form-group row">
            <div class="col-6">
                {!! Form::label('name', 'Name:') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>
            <div class="col-6">
                {!! Form::label('private', 'Private') !!}
                {!! Form::checkbox('private', 1, 0, ['class' => 'form-check-input']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-3 mt-2">
                {!! Form::submit('Create List', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>

        {!! Form::close() !!}
    </div>

@endsection
