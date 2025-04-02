<?php

namespace App\Repositories;

use App\Models\Auth;

class AuthRepositories
{
    protected $model;

    public function __construct(Auth $model)
    {
        $this->model = $model;
    }

    //busca o usuario no banco
    public function getAuth($user){
        return $this->model->where('user', $user)->first();
    }

    //insere o usuario no banco com o token gerado
    public function insertAuth($auth, $token){
        
        $this->model->create([
            'user'              => $auth['user'],
            'password'          => $auth['password'],
            'token'             => $token,
            'validate_token'    => now()->addDay()->format('Y-m-d')
        ]);
    }

    //atualiza o token do usuario
    public function updateAuth($token, $id){
        $this->model->where('id', $id)->update([
            'token' => $token,
            'validate_token' => now()->addDay()->format('Y-m-d')
        ]);    }

    //verifica a validade do token
    public function validateToken($token){
        return $this->model->where('token', $token)->first();
    }
}