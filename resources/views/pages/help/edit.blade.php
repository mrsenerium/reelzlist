@extends('layouts.no-sidebar')

@section('title', 'ReelzList - help')

@section('content')
<div class="container">
    <h2>Help Form</h2>
    <form action="{{ route('help.update', ['help' => $help->id]) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" class="form-control" value="{{ $help->title }}">
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="type">Type:</label>
            <select name="type" class="form-control" required value="{{ $help->type }}">
                <option value="general {{ $help->type == 'general' ? 'selected' : ''}}">General</option>
                <option value="feature-request" {{ $help->type == 'feature-request' ? 'selected' : ''}}>Feature Request</option>
                <option value="bug-report" {{ $help->type == 'bug-report' ? 'selected' : ''}}>Bug Report</option>
                <option value="other" {{ $help->type == 'other' ? 'selected="selected"' : '' }}>Other</option>
            </select>
            @error('type')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="message">Message:</label>
            <textarea name="message" class="form-control" rows="5"">{{ $help->message }}</textarea>
            @error('message')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        
        <div class="form-group mb-3">
            <label for="want_responset">Do They Want contacted?</label>
            <input 
                type="checkbox"
                name="want_response"
                value="1"
                {{ $help->want_response ? 'checked' : '' }} 
            >
        </div>

        <p>Submitted by: {{ $help->user->name }}</p>
        
        <p>Submitted on: {{ $help->created_at->format('M jS Y') }}</p>
        
        <p>Last Updated: {{ $help->updated_at->format('M jS Y') }}</p>
        
        <label for="status">Status:</label>
        <select class="form-control" name="status">
            <option value="open" {{ $help->status == 'open' ? 'selected' : '' }}>Open</option>
            <option value="awaiting-feedback" {{ $help->status == 'awaiting-feedback' ? 'selected' : '' }}>Awaiting Feedback</option>
            <option value="resolved" {{ $help->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
        </select>
        @error('status')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="hidden" name="read" value="1">
        <input type="hidden" name="resolved" value={{ $help->resolved ?? 0 }}>

        <textarea name="response" class="form-control mt-3 mb-3" rows="5" placeholder="Response">{{ $help->response }}</textarea>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">save</button>
            <a href="{{ route('help.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection