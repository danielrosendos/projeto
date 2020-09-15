<?php


namespace Modules\Estabelecimentos\Http\Repository;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;
use Modules\Estabelecimentos\Entities\Estabelecimento;

class EstabelecimentoRepository
{
    const DIST_MAX = 2;
    const RAIO = 3959;

    /**
     * Salvar um novo Estabelecimento
     * @param array $request
     * @param string $token
     */
    public function salvar(array $request, string $token)
    {
        $dados = JWTAuth::getPayload($token)->toArray();

        ['id' => $id_user] = $dados;

        $estabelecimento = Estabelecimento::create([
            "nome_estabelecimento" => $request["nome_estabelecimento"],
            "endereco" => $request["endereco"],
            "bairro" => $request["bairro"],
            "numero" => $request["numero"],
            "complemento" => $request["complemento"],
            "cep" => $request["cep"],
            "latitude" => $request["latitude"],
            "longitude" => $request["longitude"],
            "id_user" => $id_user
        ])->first();

        return $estabelecimento;
    }

    /**
     * Listar todos os estabelecimentos cadastrados do usuário
     * @param string $token
     */
    public function listarEstabelecimentosCadastrados(string $token)
    {
        $dados = JWTAuth::getPayload($token)->toArray();

        ['id' => $id_user] = $dados;

        $estabelecimento = Estabelecimento::where(["id_user" => $id_user])->get();

        $estabelecimento = $estabelecimento->toArray();

        if(!$estabelecimento) throw new \Exception("Não há estabelecimentos vinculado ao usuário");

        return $estabelecimento;
    }

    /**
     * Editar um estabelecimento
     * @param array $request
     * @param string $token
     */
    public function editar(array $request, string $token)
    {
        $dados = JWTAuth::getPayload($token)->toArray();

        ['id' => $id_user] = $dados;

        $estabelecimento = Estabelecimento::where([
            "id_user" => $id_user,
            "id" => $request["id"]
        ])->get();

        $estabelecimento = $estabelecimento->toArray();

        if(!$estabelecimento) throw new \Exception("Não há estabelecimentos vinculado ao usuário");

        $estabelecimento = Estabelecimento::where([
            "id_user" => $id_user,
            "id" => $request["id"]
        ])->update([
            "nome_estabelecimento" => $request["nome_estabelecimento"],
            "endereco" => $request["endereco"],
            "bairro" => $request["bairro"],
            "numero" => $request["numero"],
            "complemento" => $request["complemento"],
            "cep" => $request["cep"],
            "latitude" => $request["latitude"],
            "longitude" => $request["longitude"],
        ]);

        return $estabelecimento;
    }

    /**
     * Deletar Estabelecimento
     * @param string $id_estabelecimento
     * @param string $token
     * @throws \Exception
     */
    public function deletarEstabelecimento(string $id_estabelecimento, string $token)
    {
        $dados = JWTAuth::getPayload($token)->toArray();

        ['id' => $id_user] = $dados;

        $estabelecimento = Estabelecimento::where([
            "id_user" => $id_user,
            "id" => $id_estabelecimento
        ])->get();

        $estabelecimento = $estabelecimento->toArray();

        if(!$estabelecimento) throw new \Exception("Não há estabelecimentos vinculado ao usuário");

        Estabelecimento::where([
            "id_user" => $id_user,
            "id" => $id_estabelecimento
        ])->delete();
    }

    /**
     * Listar Estabelecimentos por um raio de 2km
     * @param string $latitude
     * @param string $longitude
     */
    public function listarEstabelecimentosPorLocalidade(string $latitude, string $longitude)
    {
        $circle_radius = self::RAIO;
        $max_distance = self::DIST_MAX;

        $estabelecimentos = DB::select(
            "SELECT * FROM (
                        SELECT id, nome_estabelecimento, endereco, bairro, numero, complemento, cep, latitude, longitude,
                        ({$circle_radius}*acos(cos(radians({$latitude})) * cos(radians(latitude)) * cos(radians(longitude)
                        - radians({$longitude})) + sin(radians({$latitude})) * sin(radians(latitude)))) AS distance FROM estabelecimento
                    ) AS distances WHERE distance < {$max_distance} ORDER BY distance"
        );

        if(!$estabelecimentos) throw new \Exception("Não Existe Estabelecimento Cadastrado nessa Area");

        return $estabelecimentos;
    }
}
