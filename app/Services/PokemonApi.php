<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PokemonApi
{
    public static function pokemonList($url, $offset, $limit): array
    {
        $response = Http::withoutVerifying()->get($url, [
            'offset' => $offset,
            'limit' => $limit,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return ['error' => 'Erro ao acessar a API'];
    }

    /**
     * Obtém detalhes de um Pokémon específico pelo nome ou ID.
     */
    public static function pokemonInfo($url): array
    {
        $response = Http::withoutVerifying()->get("{$url}");

        if ($response->successful()) {
            return $response->json();
        }

        return ['error' => 'Pokémon não encontrado'];
    }
}
