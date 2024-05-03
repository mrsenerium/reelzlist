<?php
    use Carbon\Carbon;
?>
@extends('layouts.no-sidebar')

@section('title', 'ReelzList - help')

@section('content')
<div class="container">
    <h2>Help Tickets</h2>
    <div class="card mb-3">
        <div class="card-header">
            <h3>UnResolved Help Tickets</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Want's Contact</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($unresolved as $help)
                        <tr>
                            <td>{{ $help->title }}</td>
                            <td>{{ ucfirst($help->type) }}</td>
                            <td>{{ $help->want_response ? 'Yes' : 'No' }}</td>
                            <td><?php echo Carbon::parse($help->created_at)->format('M jS Y') ?></td>
                            <td>
                                <a href="{{ route('help.show', $help->id) }}" class="btn btn-primary">View</a>
                                <a href="{{ route('help.edit', $help->id) }}" class="btn btn-secondary">Edit</a>
                                <form action="{{ route('help.destroy', $help->id) }}" 
                                    method="POST" 
                                    style="display: inline;"
                                    onsubmit="return confirm('Are you sure you want to delete this Ticket?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3>Resolved Help Tickets</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Want's Contact</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resolved as $help)
                        <tr>
                            <td>{{ $help->title }}</td>
                            <td>{{ $help->type }}</td>
                            <td>{{ $help->want_response ? 'Yes' : 'No' }}</td>
                            <td><?php echo Carbon::parse($help->created_at)->format('M jS Y') ?></td>
                            <td>
                                <a href="{{ route('help.show', $help->id) }}" class="btn btn-primary">View</a>
                                <a href="{{ route('help.edit', $help->id) }}" class="btn btn-secondary">Edit</a>
                                <form action="{{ route('help.destroy', $help->id) }}" 
                                    method="POST" 
                                    style="display: inline;"
                                    onsubmit="return confirm('Are you sure you want to delete this Ticket?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection