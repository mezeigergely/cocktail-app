@extends('layouts.main')
@section('title', 'Profile')
@section('content')
@if( auth()->check() )
<div>
    <img src="{{ auth()->user()->profileImage }}">
</div>
    @if ($userCocktails->count() > 0)
    <div class="card-body">
        <h3>{{ auth()->user()->name }}'s favourite cocktails:</h3>
        <div class="row pt-4">
            <form class="pb-3">
                <div class="checkbox checkbox-success">
                    <input name="non-alcoholic" id="non-alcoholic" type="checkbox" value="non-alcoholic">
                    <label for="non-alcoholic">Non-Alcoholic</label>
                </div>
            </form>
            @foreach ($userCocktails as $userCocktail)
                <div class="col-3 pb-4">
                    <p>{{ $userCocktail["cocktail_name"] }}<p>
                    <a href="{{ URL::route('cocktail.show', ['name' => $userCocktail["cocktail_name"]]) }}">
                        <img class="cocktails-thumbs" src="{{ $userCocktail["cocktail_image"] }}">
                    </a>
                    <form action="{{route('cocktail.delete', $userCocktail["cocktail_id"])}}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" name="deleteCocktail" value="{{ $userCocktail["cocktail_id"] }}">X</button>
                    </form>
                </div>
            @endforeach
            <p class="col-3 pb-4" id="cocktails">
            </p>
        </div>
    </div>
    @endif
@endif
@if( !auth()->check() )
    <h2 class="text-danger">You are logged in first!</h2>
@endif
@endsection
