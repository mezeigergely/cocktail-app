@extends('layouts.main')
@section('title', 'Welcome')
@section('content')
@if($errors->any())
<div>
    <h4 class="text-danger pt-3 float-end">{{$errors->first()}}</h4>
</div>
    @endif
<div class="container">
    <div class="text-center">
        <h1>Your favourite Cocktail website!</h1>
    </div>
    <div class="text-center pt-4">
        @if( !auth()->check() )
            <a href="{{ url('/login') }}" class="btn btn-primary">Login</a>
        @endif
        <a href="{{ url('/') }}" class="btn btn-secondary">I would like a random cocktail</a>
        @if( !auth()->check() )
            <a href="{{ url('/signup') }}" class="btn btn-danger">Registration</a>
        @endif

    </div>
    <div class="pt-5">
        <a href="{{ URL::route('cocktail.show', ['name' => $name]) }}">
            <img class="rounded mx-auto d-block random-cocktail-image randomCocktailImage" src={{ $img }}>
        </a>
    </div>
    <div class="text-center">
        <small>Click the image for the details</small>
    </div>
</div>
@endsection
