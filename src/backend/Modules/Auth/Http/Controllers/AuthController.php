<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Auth\Http\Repository\AuthRepository;

class AuthController extends Controller
{

    /** @var AuthRepository */
    protected $authUserRepository;

    /**
     * AuthController constructor.
     * @param AuthRepository $authRepository
     */
    public function __construct(
        AuthRepository $authRepository
    )
    {
        $this->authUserRepository = $authRepository;
    }

    /**
     * Função para fazer autenticação do usuário
     * @param Request $request
     */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), $this->camposObrigatorio(), $this->mesagemRetorno());

            if($validator->fails())
                throw new \Exception($validator->errors()->first());

            $token = $this->authUserRepository->loginUser($request->all());

            return response()->json([
                "data" => $token,
                "message" => "Usuário Logado com Sucesso"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "data" => [],
                "message" => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Validação dos campos
     * @return string[]
     */
    protected function camposObrigatorio()
    {
        return [
            "email" => "required|max:255|email",
            "password" => "required|max:255"
        ];
    }

    /**
     * Menssagens de Retorno das validações
     * @return string[]
     */
    protected function mesagemRetorno()
    {
        return [
            "email.required" => "E-mail é um campo obrigatório",
            "email.email" => "E-mail Inválido",
            "email.max" => "E-mail Inválido",
            "password.required" => "Senha Obrigatório",
            "password.max" => "Senha Inválida"
        ];
    }
}
