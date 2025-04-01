<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PokemonController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/info', function(Request $request){
    return 'Server is Ok!';
});

Route::get('/auth', [AuthController::class, 'auth']);
Route::get('/getPokemons', [PokemonController::class, 'getPokemons']);
Route::get('/pokemon', [PokemonController::class, 'pokemon']);