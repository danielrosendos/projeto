<?php


namespace Modules\Auth\Http\Repository;

use Modules\Auth\Entities\Usuarios;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    /**
     * Validar e autenticar o usuário
     * @param array $request
     */
    public function loginUser(array $request)
    {
        $usuario = Usuarios::where([
            "email" => $request["email"]
        ])->get()->first();

        if (!$usuario) throw new \Exception("Usuário ou Senha Inválidos");

        $password = Hash::check($request["password"], $usuario->password, [
            'rounds' => 12,
        ]);

        if(!$password) throw new \Exception("Usuário ou Senha Inválidos");

        return [
            'access_token' => auth('api')->login($usuario),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
