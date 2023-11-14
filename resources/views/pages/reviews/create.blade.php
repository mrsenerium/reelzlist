@extends('layouts.no-sidebar')

@section('title', 'ReelzList - New Review')

@section('content')
    <div class="container">
        <h3>New Review for {{$movie->title}}</h3>
        <p>
            This is where you will write your review
        </p>

        {!! Form::open(['route' => 'review.store', 'method' => 'post']) !!}
        {{ csrf_field() }}

        <div class="form-group row">
            <div class="col-6">
                {!! Form::label('name', 'Name of Review:') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>
            <div class="col-6">
                {!! Form::label('private', 'Private') !!}
                {!! Form::checkbox('private', 1, 0, ['class' => 'form-check']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-9">
                {!! Form::label('body', 'Review') !!}
                {!! Form::textArea('body', null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-3 mt-2">
                {!! Form::submit('Submit Review', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>

        {!! Form::close() !!}
    </div>

@endsection
