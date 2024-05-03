@extends('layouts.no-sidebar')

@section('title', 'ReelzList - help')

@section('content')
<div class="container">
    <h2>Help Form</h2>
    <form action="{{ route('help.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" class="form-control">
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="type">Type:</label>
            <select name="type" class="form-control" required>
                <option value="general">General</option>
                <option value="feature-request">Feature Request</option>
                <option value="bug-report">Bug Report</option>
                <option value="other">Other</option>
            </select>
            @error('type')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="message">Message:</label>
            <textarea name="message" class="form-control" rows="5"></textarea>
            @error('message')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        @if(auth()->check())
            <div class="form-group mb-3">
                <label for="want_responset">Do you want to be contacted?</label>
                <input type="checkbox" name="want_response" value="1">
            </div>
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            <input type="hidden" name="status" value="open">
        @endif

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Send</button>
            <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection