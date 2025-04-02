<?php

namespace App\Services;

use App\Repositories\AuthRepositories as Repositories;

class AuthServices
{
    protected $repository;

    public function __construct(Repositories $repository)
    {
        $this->repository = $repository;
    }

    // função para autenticar o usuario e gerar um token
    public function auth($user, $password)
    {
        $auth = [
            'user' => $user,
            'password' => $password
        ];
        $timestamp = time();
        $credentials = $user.$password.$timestamp;
        $token = base64_encode($credentials);
        $verifica = $this->repository->getAuth($user);
        if(!empty($verifica)){
            if($verifica->password == $password){
                $this->repository->updateAuth($token, $verifica->id);
                return $token;
            } else {
                return false;
            }
            //gero um token caso o usuario ja esteja cadastrado            
            
        } else {
            //cria o usuario e gera o token
            $this->repository->insertAuth($auth, $token);            
            return $token;
            
        }
    }

    //função para validar o token
    public function validaToken($token){
        $auth = $this->repository->validateToken($token);
        
        if(!empty($auth)){
            if($auth->validate_token > now()){
                return true;
            } else {
                return false;
            }
        }
    }
    
}