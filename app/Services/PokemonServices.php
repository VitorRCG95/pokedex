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

    //busca os pokemons do banco e os da api, faz um depara e insere os novos pokemons no banco de dados
    public function getPokemons($offset, $limit){
        $getPokemons = $this->repository->getAll();
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
        } else {
            return false;
        }
    }

    //busca um pokemon no banco de dados
    public function pokemon($id){
        if($id != 0){
            //busca pokemon no banco de dados
            $pokemon = $this->repository->getId($id);
            if($pokemon){
                return $pokemon;
            } else {
                return false;
            }
        } else {
            return false;
        }
       
    }
}
