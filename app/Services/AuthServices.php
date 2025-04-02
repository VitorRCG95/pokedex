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

    public function auth($user, $password)
    {
        $auth = [
            'user' => $user,
            'password' => $password
        ];
        $timestamp = time();
        $credentials = $user.$password.$timestamp;
        $token = base64_encode($credentials);
        $verifica = $this->repository->getAuth($auth);
        
        if($verifica){
            
            //gero um token caso o usuario ja esteja cadastrado            
            $this->repository->updateAuth($token, $verifica->id);
            return $token;
            /*
            return response()->json([
                'token' => $token,
                'success' => "token gerado com sucesso"
            ]);
            */
        } else {
            //cria o usuario e gera o token
            $this->repository->insertAuth($auth, $token);
            //Auth::create(['user' => $request->getUser(), 'password' => $request->getPassword(), 'token' => $token]);
            
            return $token;
            
        }
    }

    public function validaToken($token){
        $auth = $this->repository->validateToken($token);
        if($auth['validate_token'] < now()){
            return true;
        } else {
            return false;
        }
    }
    
}