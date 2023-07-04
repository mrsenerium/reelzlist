@php
    use Carbon\Carbon;
@endphp

@extends('layouts.no-sidebar')

@section('title', 'ReelzList')

@section('content')

<div class="row">
    <p>This is a page for a single Movie</p>
</div>

@if(isset($movie))
    <pre>
        <?php var_dump($movie) ?>
    </pre>
@endif

@endsection