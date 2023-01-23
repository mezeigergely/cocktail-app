@extends('layouts.main')
@section('title', 'Welcome')
@section('content')
<div class="container">
    <div class="text-center">
        <h1>Your favourite Cocktail website!</h1>
    </div>
    <div class="text-center pt-4">
        <a href="{{ url('/login') }}" class="btn btn-primary">Login</a>
        <a href="{{ url('/') }}" class="btn btn-secondary">I would like a random cocktail</a>
        <a href="{{ url('/signup') }}" class="btn btn-danger">Registration</a>
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
