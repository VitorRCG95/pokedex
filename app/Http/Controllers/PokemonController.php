<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auth;
use App\Models\Pokemon;
use App\Services\PokemonApi;

class PokemonController extends Controller
{

    public function getPokemons(Request $request){
        $auth = $request->query('token', null);
        if($auth != null){
            $auth = Auth::where('token', $auth)->first();
            if(!$auth){
                return response()->json(['error' => 'Token não encontrado ou invalido']);
            }
        } else {
            return response()->json(['error' => 'Token não encontrado ou invalido']);
        }
        $getPokemons = Pokemon::pluck('id_pokemon')->toArray();
        $offset = $request->query('offset', 0); // Padrão: 0
        $limit = $request->query('limit', 20);  // Padrão: 20
        $list = PokemonApi::pokemonList('https://pokeapi.co/api/v2/pokemon', $offset, $limit);
        $pokemonInsert = [];
        foreach($list['results'] as $pokemon){
            $pokemonInfo = PokemonApi::pokemonInfo($pokemon['url']);
            if(!in_array($pokemonInfo['id'], $getPokemons)){
                $pokemonInsert[] = [
                    'id_pokemon' => $pokemonInfo['id'],
                    'name' => $pokemonInfo['name'],
                    'height' => $pokemonInfo['height'],
                    'weight' => $pokemonInfo['weight'],
                    'type1' => $pokemonInfo['types'][0]['type']['name'],
                    'type2' => isset($pokemonInfo['types'][1]) ? $pokemonInfo['types'][1]['type']['name'] : null,
                    'image' => $pokemonInfo['sprites']['other']['official-artwork']['front_default'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        if(!empty($pokemonInsert)){
            Pokemon::insert($pokemonInsert);
            return response()->json(['success' => 'Pokemons inseridos com sucesso']);
        } else {
            return response()->json(['error' => 'Pokémons já cadastrados']);
        }
    }

    public function pokemon(Request $request){
        $auth = $request->query('token', null);
        if($auth != null){
            $auth = Auth::where('token', $auth)->first();
            if(!$auth){
                return response()->json(['error' => 'Token não encontrado ou invalido']);
            }
        } else {
            return response()->json(['error' => 'Token não encontrado ou invalido']);
        }
        $id = $request->query('id', 0);
        if($id != 0){
            $pokemon = Pokemon::where('id_pokemon', $id)->first();
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
