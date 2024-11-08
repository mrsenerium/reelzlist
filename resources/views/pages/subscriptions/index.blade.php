@extends('layouts.no-sidebar')

@section('title', 'ReelzList - Subscriptions')

@section('content')
<div class="container mt-4">
    
    <!-- Subscription Search Form -->
    <div class="row mb-4">
        <form class="d-flex" method="get" action="{{ route('subscriptions.index') }}">
            @csrf
            <input
                name="q"
                class="form-control me-sm-2"
                type="search"
                placeholder="Search Subscriptions"
                value="{{ $q ?? request()->input('q') }}"
            >
            <button class="btn btn-primary my-2 my-sm-0" type="submit">
                Search
            </button>
            <a href="{{ route('subscriptions.index') }}" class="btn btn-secondary my-2 my-sm-0">
                Clear
            </a>   
        </form>
    </div>

    <!-- Subscriptions Table -->
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">Subscription Name</th>
                <th scope="col">Logo</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subscriptions as $subscription)
            <tr>
                <td>{{ $subscription->name }}</td>
                <td>
                    <img src="{{ $subscription->url }}" alt="{{ $subscription->name }}" style="width: 100px; height: 100px;">
                </td>
                <td>
                    @if ($userSubscriptions->contains($subscription->id))
                        <!-- Unsubscribe Form -->
                        <form action="{{ route('subscriptions.destroy', $subscription->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="q" value="{{ $q ?? request()->input('q') }}">
                            <button class="btn btn-danger btn-sm" type="submit">Unsubscribe</button>
                        </form>
                    @else
                        <!-- Subscribe Form -->
                        <form action="{{ route('subscriptions.store') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="subscription_id" value="{{ $subscription->id }}">
                            <button class="btn btn-info btn-sm" type="submit">Subscribe</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $subscriptions->links() }}
    </div>

</div>
@endsection
