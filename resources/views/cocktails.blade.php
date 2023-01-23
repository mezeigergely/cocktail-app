@extends('layouts.main')
@section('title', 'Cocktails')
@section('content')
<h2>Cocktails</h2>
<div class="row pt-3">
    @foreach ($cocktailArray as $cocktail)
        <div class="col-3 pb-2">
            <p>{{ $cocktail["cocktailName"] }}<p>
            <a href="{{ URL::route('cocktail.show', ['name' => $cocktail["cocktailName"]]) }}">
                <img class="cocktails-thumbs" src="{{ $cocktail["cocktailImage"] }}">
            </a>
        </div>

    @endforeach
</div>
@endsection
