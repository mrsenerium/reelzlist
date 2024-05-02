@extends('layouts.no-sidebar')

@section('title', 'ReelzList - help')

@section('content')
<div class="container">
    <h2>Help Form</h2>
    <form action="{{ route('help.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="subject">Subject:</label>
            <input type="text" name="subject" class="form-control">
        </div>

        <div class="form-group">
            <label for="type">Type:</label>
            <select name="type" class="form-control" required>
                <option value="feature-request">Feature Request</option>
                <option value="bug-report">Bug Report</option>
                <option value="general">General</option>
            </select>
        </div>

        <div class="form-group">
            <label for="message">Message:</label>
            <textarea name="message" class="form-control" rows="5"></textarea>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Send</button>
            <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection