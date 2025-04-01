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
//rota para criar o token
Route::get('/auth', [AuthController::class, 'auth']);
//rota para consulta a api pokemon e gravar os dados no banco de dados
Route::get('/getPokemons', [PokemonController::class, 'getPokemons']);
//rota para consultar um pokemon especifico no banco de dados
Route::get('/pokemon', [PokemonController::class, 'pokemon']);