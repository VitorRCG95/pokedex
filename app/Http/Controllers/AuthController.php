<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function auth(Request $request){
        // Verifica se o usuário e senha foram enviados no Basic Auth
    if (!$request->getUser() || !$request->getPassword()) {
        return response()->json([
            'error' => 'Usuário e senha não encontrados, verifique se esta enviando pelo método Basic Auth.'
        ]);
    }
        $verifica = Auth::where('user', $request->getUser())->where('password', $request->getPassword())->first();
        
        if($verifica){
            $credentials = $request->getUser().$request->getPassword();
            $token = base64_encode($credentials);
            Auth::updated(['token' => $token], $verifica->id);
            return response()->json([
                'token' => $token,
                'success' => "token gerado com sucesso"
            ]);

        } else {
            $credentials = $request->getUser().$request->getPassword();
            $token = base64_encode($credentials);
            Auth::create(['user' => $request->getUser(), 'password' => $request->getPassword(), 'token' => $token]);
            return response()->json([
                'token' => $token,
                'success' => "Usuário criado com sucesso"
            ]);
        }
    }
}
