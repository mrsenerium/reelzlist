@extends('layouts.no-sidebar')

@section('title', 'ReelzList - Help')

@section('content')
    <div class="container">
        <h2>Help Ticket {{ $help->id }}</h2>
        <div class="row mb-2">
            <div class="col-2">
                Title:
            </div>
            <div class="col-9">
                {{ $help->title }}
            </div>
        </div>
        @if($help->user_id)
            <div class="row mb-2">
                <div class="col-2">
                    User:
                </div>
                <div class="col-9">
                    {{ $help->user->name }}
                </div>
            </div>
        @endif
        <div class="row mb-2">
            <div class="col-2">
                Want Response:
            </div>
            <div class="col-9">
                {{ $help->want_response ? 'Yes' : 'No' }}
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-2">
                Created:
            </div>
            <div class="col-9">
                {{ $help->created_at->format('m/d/Y h:i A') }}
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-2">
                Updated:
            </div>
            <div class="col-9">
                {{ $help->updated_at->format('m/d/Y h:i A') }}
            </div>
        </div>
        @if($help->response)
            <div class="row mb-2">
                <div class="col-2">
                    Response:
                </div>
                <div class="col-9">
                    {!! nl2br(e($help->response)) !!}
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-2">
                    Resolved:
                </div>
                <div class="col-9">
                    {{ $help->resolved_at->format('m/d/Y h:i A') }}
                </div>
            </div>
        @endif
        <div class="row mb-2">
            <div class="col-2">
                Type:
            </div>
            <div class="col-9">
                {{ $help->type }}
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-2">
                Status:
            </div>
            <div class="col-9">
                {{ $help->status }}
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-2">
                Message:
            </div>
            <div class="col-9">
                {!! nl2br(e($help->message)) !!}
            </div>
        </div>
    </div>

@endsection