@extends('layouts.main')
@section('title', 'Login')
@section('content')
<h2>Login</h2>
<form method="POST" action="/login">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email">
    </div>

    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>

    <div class="form-group">
        <button style="cursor:pointer" type="submit" class="btn btn-primary">Login</button>
    </div>
</form>
<div>
    <span>Not registered yet?</span>
    <a class="btn btn-danger" href="{{ url('/signup') }}">Registration</a>
</div>
@if($errors->any())
        <h4 class="text-danger pt-3 position-absolute">{{$errors->first()}}</h4>
    @endif
@endsection
