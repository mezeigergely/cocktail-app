<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// SIGN UP
Route::get('/signup', [UserController::class, 'signUp']);
Route::post('signup', [UserController::class, 'makeSignUp']);

