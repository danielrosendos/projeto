<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Auth\Http\Repository\UserRepository;

class UserController extends Controller
{

    /** @var UserRepository */
    protected $userRepository;

    /**
     * RegisterController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Pegar dados do usuário
     * @param Request $request
     */
    public function show(Request $request)
    {
        try {

            $token = $request->bearerToken();

            $userData = $this->userRepository->obterDados($token);

            return response()->json([
                "data" => $userData,
                "message" => "Dados Consultados Com Sucesso"
            ], 200);
        } catch (\Exception $e) {
            return  response()->json([
                "data" => [],
                "message" => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Editar Dados do Usuário
     * @param Request $request
     */
    public function edit(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $this->camposObrigatorio(), $this->mesagemRetorno());

            if($validator->fails())
                throw new \Exception($validator->errors()->first());

            $this->userRepository->editUser($request->all(), $request->bearerToken());

            return response()->json([
                "data" => [],
                "message" => "Dados Alterados Com Sucesso"
            ], 200);
        } catch (\Exception $e) {
            return  response()->json([
                "data" => [],
                "message" => $e->getMessage()
            ], 401);
        }
    }

    /**
    * Verificar e validar os campos do envio dos campos
    * @return string[]
    */
    protected function camposObrigatorio()
    {
        return [
            "primeiro_nome" => "required|max:255",
            "ultimo_nome" => "required|max:255",
            "user_adress" => "required",
            "user_adress.endereco" => "required|max:255",
            "user_adress.bairro" => "required|max:255",
            "user_adress.numero" => "required|max:255",
            "user_adress.cep" => "required|max:9|regex:/^[0-9]{5}-[0-9]{3}$/",
        ];
    }

    /**
     * Mensagens de Retorno quando a validação pega algum campo
     * @return string[]
     */
    protected function mesagemRetorno()
    {
        return [
            "primeiro_nome.required" => "Nome é Obrigatório",
            "primeiro_nome.max" => "Nome Inválido",
            "ultimo_nome.required" => "Sobrenome é Obrigatório",
            "ultimo_nome.max" => "Sobrenome Inválido",
            "user_adress.required" => "Endereço é Obrigatório",
            "user_adress.endereco.required" => "Endereço Inválido",
            "user_adress.endereco.max" => "Endereço Inválido",
            "user_adress.bairro.required" => "Bairro Inválido",
            "user_adress.bairro.max" => "Bairro Inválido",
            "user_adress.numero.required" => "Número Inválido",
            "user_adress.numero.max" => "Número Inválido",
            "user_adress.cep.required" => "CEP Inválido",
            "user_adress.cep.max" => "CEP Inválido",
            "user_adress.cep.regex" => "CEP Inválido",
        ];
    }
}
