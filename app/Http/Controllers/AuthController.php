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
        /*
        // Verifica se o usuário e senha foram enviados no Basic Auth
    if (!$request->getUser() || !$request->getPassword()) {
        return response()->json([
            'error' => 'Usuário e senha não encontrados, verifique se esta enviando pelo método Basic Auth.'
        ]);
    }
        $verifica = Auth::where('user', $request->getUser())->where('password', $request->getPassword())->first();
        
        if($verifica){
            //gero um token caso o usuario ja esteja cadastrado
            $credentials = $request->getUser().$request->getPassword();
            $token = base64_encode($credentials);
            Auth::updated(['token' => $token], $verifica->id);
            return response()->json([
                'token' => $token,
                'success' => "token gerado com sucesso"
            ]);

        } else {
            //cria o usuario e gera o token
            $credentials = $request->getUser().$request->getPassword();
            $token = base64_encode($credentials);
            Auth::create(['user' => $request->getUser(), 'password' => $request->getPassword(), 'token' => $token]);
            return response()->json([
                'token' => $token,
                'success' => "Usuário criado com sucesso"
            ]);
        }*/
    } 
}
