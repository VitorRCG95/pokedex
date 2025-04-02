<?php

namespace App\Repositories;

use App\Models\Pokemon;

class PokemonRepositories
{
    /**
     * @var PokemonsModel
     */
    protected $model;

    public function __construct(Pokemon $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->pluck('id_pokemon')->toArray();
    }
    public function getId(int $id)
    {
        $query = $this->model->select(['*']);

        if ($id !== 0) {
            $query->where('id', $id);
        }

        return $query->get();
    }

    public function insertDb($pokemon) {
        $this->model->insert($pokemon);
    }
}