<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $http = new \GuzzleHttp\Client;

        try {
            $response = $http->post(config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request->username,
                    'password' => $request->password,
                ]
            ]);

            return $response->getBody();

        } catch (\GuzzleHttp\Exception\BadResponseException $e) {

            if ($e->getCode() === 400) {
                return response()->json('El nombre de usuario o contraseña son incorrectos.', $e->getCode());
            } else if ($e->getCode() === 401) {
                return response()->json('Sus credenciales son incorrectas, por favor ingrese sus credenciales nuevamente.', $e->getCode());
            }
                Log::info("CODE:" . $e->getCode());
            return response()->json('Ha ocurrido un error en el servidor.', $e->getCode());
        }
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json('Sesion cerrada correctamente.', 200);
    }

}
