<?php


namespace Modules\Auth\Http\Repository;

use Modules\Auth\Entities\Usuarios;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Entities\EnderecoUsuario;

class RegisterRepository
{

    /**
     * Salvar e criar um novo usuário
     * @param array $request
     * @return mixed
     */
    public function salvar(array $request)
    {

        $endereco = EnderecoUsuario::create([
            "endereco" => $request["endereco"],
            "bairro" => $request["bairro"],
            "numero" => $request["numero"],
            "complemento" => $request["complemento"],
            "cep" => $request["cep"]
        ])->first();

        $usuario = Usuarios::create([
            "primeiro_nome" => $request["primeiro_nome"],
            "ultimo_nome" => $request["ultimo_nome"],
            "email" => $request["email"],
            "cpf" => $request["cpf"],
            "password" => Hash::make($request["password"], [
                'rounds' => 12,
            ]),
            "id_adress" => $endereco->id
        ])->first();

        return $usuario;
    }
}
