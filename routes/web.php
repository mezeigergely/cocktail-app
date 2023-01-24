<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/', [SiteController::class, 'index']);

Route::get('/search',[SiteController::class,'searchByName']);

Route::get('/cocktails', [SiteController::class,'searchByName']);

Route::get('/cocktail/{name}',[SiteController::class,'getCocktailByName'])->name('cocktail.show');

// LOGIN
Route::get('/login',[UserController::class,'signIn']);
Route::post('login',[UserController::class,'makeSignIn']);

// LOGINED USER
Route::get('/profile', [SiteController::class,'profile']);
Route::post('cocktail/save', [SiteController::class,'saveFavCocktail']);
Route::get('/logout', [UserController::class,'logout']);

// REGISTRATION
Route::get('/signup', [UserController::class, 'signUp']);
Route::post('signup', [UserController::class, 'makeSignUp']);
