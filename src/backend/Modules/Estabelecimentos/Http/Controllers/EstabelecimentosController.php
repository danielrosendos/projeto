<?php

namespace Modules\Estabelecimentos\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Modules\Estabelecimentos\Http\Repository\EstabelecimentoRepository;

class EstabelecimentosController extends Controller
{

    /** @var EstabelecimentoRepository */
    protected $estabelecimentoRepository;

    /**
     * EstabelecimentosController constructor.
     * @param EstabelecimentoRepository $estabelecimentoRepository
     */
    public function __construct(
        EstabelecimentoRepository $estabelecimentoRepository
    )
    {
        $this->estabelecimentoRepository = $estabelecimentoRepository;
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), $this->camposObrigatorio(), $this->mesagemRetorno());

            if($validator->fails())
                throw new \Exception($validator->errors()->first());

            $requestGoogle = $this->requestInfoGoogle($request->all());

            $token = $request->bearerToken();
            $request = $request->all();

            $request['latitude'] = $requestGoogle['latitude'];
            $request['longitude'] = $requestGoogle['longitude'];

            $this->estabelecimentoRepository->salvar($request, $token);

            return response()->json([
                "data" => [],
                "message" => "Estabelecimento Cadastrado com Sucesso"
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "data" => [],
                "message" => $e->getMessage()
            ], 401);
        }
    }

    public function show(Request $request)
    {
        try {
            $estabelecimentos = $this->estabelecimentoRepository->listarEstabelecimentosCadastrados($request->bearerToken());

            return response()->json([
                "data" => [
                    "estabelecimentos" => $estabelecimentos
                ],
                "message" => "Estabelecimentos Consultados Com Sucesso"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "data" => [],
                "message" => $e->getMessage()
            ], 404);
        }
    }

    protected function edit(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), $this->camposObrigatorio(), $this->mesagemRetorno());

            if($validator->fails())
                throw new \Exception($validator->errors()->first());

            $requestGoogle = $this->requestInfoGoogle($request->all());

            $token = $request->bearerToken();
            $request = $request->all();

            $request['latitude'] = $requestGoogle['latitude'];
            $request['longitude'] = $requestGoogle['longitude'];

            $this->estabelecimentoRepository->editar($request, $token);

            return response()->json([
                "data" => [],
                "message" => "Estabelecimento Editado com Sucesso"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "data" => [],
                "message" => $e->getMessage()
            ], 401);
        }
    }

    protected function delete(Request $request)
    {
        try {
            $id_estabelecimento = $request->query('id_estabelecimento');

            $this->estabelecimentoRepository->deletarEstabelecimento($id_estabelecimento, $request->bearerToken());

            return response()->json([
                "data" => [],
                "message" => "Estabelecimento Removido com Sucesso"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "data" => [],
                "message" => $e->getMessage()
            ], 401);
        }
    }

    public function searchPorLocale(Request $request)
    {
        try {
            $endereco = $request->query('endereco');

            $requestGoogle = $this->requestInfoGoogleByAddress($endereco);

            $latitude = $requestGoogle['latitude'];
            $longitude = $requestGoogle['longitude'];

            $estabelecimentos = $this->estabelecimentoRepository->listarEstabelecimentosPorLocalidade($latitude, $longitude);

            return response()->json([
                "data" => [
                    "estabelecimentos" => $estabelecimentos
                ],
                "message" => "Estabelecimentos Consultados Com Sucesso"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "data" => [],
                "message" => $e->getMessage()
            ], 401);
        }
    }

    public function showAll(Request $request)
    {
        try {
            $estabelecimentos = $this->estabelecimentoRepository->listarTodosOsEstabelecimentos();

            return response()->json([
                "data" => [
                    "estabelecimentos" => $estabelecimentos
                ],
                "message" => "Estabelecimentos Consultados Com Sucesso"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "data" => [],
                "message" => $e->getMessage()
            ], 401);
        }
    }

    public function requestInfoGoogle(array $request)
    {
        $address = "{$request['endereco']}+{$request['bairro']}+{$request['numero']}+{$request['cep']}";

        $address = str_replace(" ", "+", $address);

        $response = Http::get(
            "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key="
        );

        $response = $response->json();

        return [
            "latitude" => $response['results'][0]['geometry']['location']['lat'],
            "longitude" => $response['results'][0]['geometry']['location']['lng']
        ];
    }

    public function requestInfoGoogleByAddress(string $address)
    {
        $response = Http::get(
            "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key="
        );

        $response = $response->json();

        return [
            "latitude" => $response['results'][0]['geometry']['location']['lat'],
            "longitude" => $response['results'][0]['geometry']['location']['lng']
        ];
    }

    /**
     * @return string[]
     */
    protected function camposObrigatorio()
    {
        return [
            "nome_estabelecimento" => "required|max:255",
            "endereco" => "required|max:255",
            "bairro" => "required|max:255",
            "numero" => "required|max:255",
            "cep" => "required|max:255|regex:/^[0-9]{5}-[0-9]{3}$/",
        ];
    }

    /**
     *
     */
    protected function mesagemRetorno()
    {
        return [
            "nome_estabelecimento.required" => "Nome Estabelecimento Obrigatório",
            "nome_estabelecimento.max" => "Nome Estabelecimento Inválido",
            "endereco.required" => "Endereço Obrigatório",
            "endereco.max" => "Endereço Inválido",
            "bairro.required" => "Bairro Obrigatório",
            "bairro.max" => "Bairro Inválido",
            "numero.required" => "Número Obrigatório",
            "numero.max" => "Número Inválido",
            "cep.required" => "CEP Obrigatório",
            "cep.max" => "CEP Inválido",
            "cep.regex" => "CEP Inválido"
        ];
    }
}
