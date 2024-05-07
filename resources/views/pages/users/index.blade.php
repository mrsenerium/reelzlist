@extends('layouts.no-sidebar')

@section('title', 'ReelzList - Users')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h2>User Administration</h2>
            </div>
            <div class="col-6">
                <a href="{{ route('help.index') }}" class="btn btn-info float-right">Help Tickets</a>
            </div>
        </div>
        <div class="row">
            <table class="table">
                <tr class="table-row">
                    <td>Name</td>
                    <td>Email</td>
                    <td>Role</td>
                </tr>
                @foreach($users as $user)
                    <tr class="table-row">
                        <td><a href="{{ route('users.show', [$user->id]) }}">{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td><a href="{{ route('users.edit', [$user->id]) }}" class="btn btn-info">Edit User</a></td>
                        <td>
                            @if(!empty($user->profile))
                                <a href="{{ route('profile.edit', ['profile' => $user->profile->id]) }}" class="btn btn-info">Edit Profile</a>
                            @else
                                {!! Form::open(['route' => 'profile.store', 'method' => 'post']) !!}
                                {{ csrf_field() }}
                                {!! Form::hidden('user_id', $user->id) !!}
                                {!! Form::submit('Create Profile', ['class' => 'btn btn-info']) !!}
                                {!! Form::close() !!}
                            @endif
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection
