<?php


namespace Modules\Auth\Http\Repository;


use Tymon\JWTAuth\Facades\JWTAuth;
use Modules\Auth\Entities\Usuarios;
use Modules\Auth\Entities\EnderecoUsuario;

class UserRepository
{
    /**
     * Obtem dados do clientes para ser consumido na tela de edição
     * de dados do usuário
     * @param string $token
     * @return mixed
     */
    public function obterDados(string $token)
    {
        $dados = JWTAuth::getPayload($token)->toArray();

        ['id' => $id] = $dados;

        $usuario = Usuarios::where([
            "id" => $id
        ])->with('user_adress')->get()->first();

        return $usuario;
    }

    /**
     * Alterar Dadaos do Usuário
     * @param string $token
     * @param array $request
     */
    public function editUser(array $request, string $token)
    {
        $dados = JWTAuth::getPayload($token)->toArray();

        ['id' => $id] = $dados;

        $usuario = Usuarios::where([
            "id" => $id
        ])->with('user_adress')->get()->first();

        Usuarios::where(["id" => $id])->update([
            "primeiro_nome" => $request["primeiro_nome"],
            "ultimo_nome" => $request["ultimo_nome"]
        ]);

        EnderecoUsuario::where([
            "id" => $usuario->id_adress
        ])->update([
            "endereco" => $request["user_adress"]["endereco"],
            "bairro" => $request["user_adress"]["bairro"],
            "numero" => $request["user_adress"]["numero"],
            "complemento" => $request["user_adress"]["complemento"],
            "cep" => $request["user_adress"]["cep"]
        ]);
    }
}
