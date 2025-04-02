<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthServices as Token;
use App\Services\PokemonServices as Pokemon;

class PokemonController extends Controller
{

    protected $tokenService;
    protected $pokemonService;

    public function __construct(Token $tokenService, Pokemon $pokemonService)
    {
        $this->tokenService = $tokenService;
        $this->pokemonService = $pokemonService;
    }

    public function getPokemons(Request $request){
        $auth = $request->query('token', null);
        if($auth != null){
            $auth = $this->tokenService->validaToken($auth);
            if(!$auth){
                return response()->json(['error' => 'Token invalido, favor gerar um novo token']);
            }
            if(!$auth){
                return response()->json(['error' => 'Token não encontrado ou invalido']);
            }
        } else {
            return response()->json(['error' => 'Token não encontrado ou invalido']);
        }

        $offset = $request->query('offset', 0);
        $limit = $request->query('limit', 20);
        $pokemons = $this->pokemonService->getPokemons($offset, $limit);
        if($pokemons){
            return response()->json(['success' => 'Pokemons inseridos com sucesso']);
        } else {
            return response()->json(['error' => 'Pokémons já cadastrados']);
        }
    }

    public function pokemon(Request $request){
        $auth = $request->query('token', null);
        if($auth != null){
            $auth = $this->tokenService->validaToken($auth);
            if(!$auth){
                return response()->json(['error' => 'Token invalido, favor gerar um novo token']);
            }
            if(!$auth){
                return response()->json(['error' => 'Token não encontrado ou invalido']);
            }
        } else {
            return response()->json(['error' => 'Token não encontrado ou invalido']);
        }
        $id = $request->query('id', 0);
        if($id != 0){
            //busca pokemon no banco de dados
            $pokemon = $this->pokemonService->pokemon($id);
            if($pokemon){
                return response()->json($pokemon);
            } else {
                return response()->json(['error' => 'Nenhum Pokémon ou Id encontrado']);
            }
        } else {
            return response()->json(['error' => 'Nenhum Pokémon ou Id encontrado']);
        }
    }
}
