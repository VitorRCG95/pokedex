<?php

namespace App\Services;

use App\Repositories\PokemonRepositories as Repositories;
use App\Services\PokemonApi;
class PokemonServices {
    protected $repository;

    public function __construct(Repositories $repository)
    {
        $this->repository = $repository;
    }
    public function getPokemons($offset, $limit){
        //verifica token
        /*
        $auth = $request->query('token', null);
        if($auth != null){
            $auth = Auth::where('token', $auth)->first();
            if(!$auth){
                return response()->json(['error' => 'Token não encontrado ou invalido']);
            }
        } else {
            return response()->json(['error' => 'Token não encontrado ou invalido']);
        }
        */
        //busca pokemons no banco de dados
        $getPokemons = $this->repository->getAll();
        //$offset = $request->query('offset', 0);
        //$limit = $request->query('limit', 20);
        //busca pokemons na api pokemon
        $list = PokemonApi::pokemonList('https://pokeapi.co/api/v2/pokemon', $offset, $limit);
        $pokemonInsert = [];
        foreach($list['results'] as $pokemon){
            //pega a url do pokemon especifico para buscar os dados 
            $pokemonInfo = PokemonApi::pokemonInfo($pokemon['url']);
            //verifica se o pokemon já está cadastrado no banco de dados
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
            $this->repository->insertDb($pokemonInsert);
            return true;
            //return response()->json(['success' => 'Pokemons inseridos com sucesso']);
        } else {
            return false;
            //return response()->json(['error' => 'Pokémons já cadastrados']);
        }
    }

    public function pokemon($id){
        //verifica token
        /*
        $auth = $request->query('token', null);
        if($auth != null){
            $auth = Auth::where('token', $auth)->first();
            if(!$auth){
                return response()->json(['error' => 'Token não encontrado ou invalido']);
            }
        } else {
            return response()->json(['error' => 'Token não encontrado ou invalido']);
        }
            */
        //$id = $request->query('id', 0);
        if($id != 0){
            //busca pokemon no banco de dados
            $pokemon = $this->repository->getId($id);
            //$pokemon = Pokemon::where('id_pokemon', $id)->first();
            if($pokemon){
                return $pokemon;
            } else {
                return false;
                //return response()->json(['error' => 'Nenhum Pokémon ou Id encontrado']);
            }
        } else {
            return false;
            //return response()->json(['error' => 'Nenhum Pokémon ou Id encontrado']);
        }
       
    }
}
