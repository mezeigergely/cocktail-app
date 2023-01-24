@extends('layouts.main')
@section('title', 'Profile')
@section('content')
@if( auth()->check() )
<div>
    <h2>{{ auth()->user()->name }}</h2>
</div>
<div>
    <img src="{{ auth()->user()->profileImage }}">
</div>
@endif
@if( !auth()->check() )
    <h2 class="text-danger">You are logged in first!</h2>
@endif
@endsection
