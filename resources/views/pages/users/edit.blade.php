@extends('layouts.no-sidebar')

@section('title', 'ReelzList - Users')

@section('content')
<div class="container">
    <h2>Edit User</h2>
    <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="form-group">
            <label for="role">Role:</label>
            <select name="role" class="form-control" required>
                <option value="super-admin" {{ $user->role === 'super-admin' ? 'selected' : '' }}>Super Admin</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="pleb" {{ $user->role === 'pleb' ? 'selected' : '' }}>Pleb</option>
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('users.destroy', ['user' => $user->id]) }}" class="btn btn-danger"
               onclick="event.preventDefault(); document.getElementById('delete-form').submit();">
                Delete
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

    <!-- Delete form -->
    <form id="delete-form" action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST"
          style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection