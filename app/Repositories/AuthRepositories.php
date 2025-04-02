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
    public function getAuth($auth){
        return $this->model->where('user', $auth)->where('password', $auth)->first();
    }
    public function insertAuth($auth, $token){
        $this->model->create([
            'user'              => $auth['user'],
            'password'          => $auth['password'],
            'token'             => $token,
            'validate_token'    => now()->addDay()->format('Y-m-d')
        ]);
    }

    public function updateAuth($token, $id){
        $this->model->updated(['token' => $token, 'validate_token' => now()->addDay()->format('Y-m-d')], $id);
    }

    public function validateToken($token){
        return $this->model->where('token', $token)->first();
    }
}