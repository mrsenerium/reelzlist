@extends('layouts.no-sidebar')

@section('title', 'ReelzList - Subscriptions')

@section('content')
<div class="container">
    <table>
        <thead>
            <tr>
                <th>Subscription Name</th>
                <th>Logo</th>
        </thead>
        <tbody>
            @foreach($subscriptions as $subscription)
            <tr>
                <td>{{ $subscription->name }}</td>
                <td><img src="{{ $subscription->url }}" alt="{{ $subscription->name }}" style="width: 100px; height: 100px;"></td>
            </tr>
            @endforeach
        </tbody>
</div>
@endsection