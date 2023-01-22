<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/', [SiteController::class, 'index']);

// SIGN UP
Route::get('/signup', [UserController::class, 'signUp']);
Route::post('signup', [UserController::class, 'makeSignUp']);
