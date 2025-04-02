<?php

namespace App\Http\Controllers;

use App\Services\AuthServices as Service;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function auth(Request $request){
        if (!$request->getUser() || !$request->getPassword()) {
            return response()->json([
                'error' => 'Usuário e senha não encontrados, verifique se esta enviando pelo método Basic Auth.'
            ]);
        }
        $token = $this->service->auth($request->getUser(), $request->getPassword());
        return response()->json([
            'token' => $token,
            'success' => "token gerado com sucesso"
        ]);
    } 
}
