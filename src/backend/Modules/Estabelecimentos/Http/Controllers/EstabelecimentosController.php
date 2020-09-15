<?php

namespace Modules\Estabelecimentos\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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

            $this->estabelecimentoRepository->salvar($request->all(), $request->bearerToken());

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

            $this->estabelecimentoRepository->editar($request->all(), $request->bearerToken());

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
            $latitude = $request->query('latitude');
            $longitude = $request->query('longitude');

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
            "latitude" => "required|numeric",
            "longitude" => "required|numeric",
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
            "cep.regex" => "CEP Inválido",
            "latitude.required" => "Latitude Obrigatório",
            "latitude.numeric" => "Latitude Inválido",
            "longitude.required" => "Longitude Obrigatório",
            "longitude.numeric" => "Longitude Inválido",
        ];
    }
}
