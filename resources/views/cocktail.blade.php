<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>-->
@extends('layouts.main')
@section('title', 'Cocktail')
@section('content')
<div class="row w-100 pt-5">
    <div class="col-2"></div>
    <div class="col-4">
        <img class="img-fluid" src="{{ $img }}">
    </div>
    <div class="col-4">
        <div class="cocktail-name"><h1>{{ $name }}</h1></div>
        @if( auth()->check() )
        <form action="save" method="POST">
            @csrf
            <button type="submit" class="btn btn-info btn-round" name="saveCocktail" value="{{ $id }}">Add to favourites</button>
        </form>
        @endif
        <div class="cocktail-instructions pt-3">
            <h4>Instructions:</h4>
            <span>{{ $instru }}</span>
        </div>
        <div class="cocktail-ingredients pt-3">
            <h4>Ingredients:</h4>
            <ul>
                @foreach ($ingredients as $key => $value)
                    @if ($key != '')
                        <li>{{ $value }} {{ $key }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="cocktail-glass pt-2">
            <h4>Glass:</h4>
            <span>{{ $glass }}</span>
        </div>
        @if(session()->has('message'))
            <div class="alert alert-success pt-3">
                {{ session()->get('message') }}
            </div>
        @endif
        @if($errors->any())
            <h4 class="text-danger pt-3">{{$errors->first()}}</h4>
        @endif
    </div>
</div>

@endsection
