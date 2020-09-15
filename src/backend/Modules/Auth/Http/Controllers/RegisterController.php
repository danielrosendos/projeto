<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Auth\Http\Repository\RegisterRepository;

class RegisterController extends Controller
{

    /** @var RegisterRepository */
    protected $registerRepository;

    /**
     * RegisterController constructor.
     * @param RegisterRepository $registerRepository
     */
    public function __construct(
        RegisterRepository $registerRepository
    )
    {
        $this->registerRepository = $registerRepository;
    }

    /**
     * Fução para receber a requisição de registrar um novo usuário
     * @param Request $request
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), $this->camposObrigatorio(), $this->mesagemRetorno());

            if($validator->fails())
                throw new \Exception($validator->errors()->first());

            $this->registerRepository->salvar($request->all());

            return response()->json([
                "data" => [],
                "message" => "Usuário Cadastrado Com Sucesso"
            ], 201);
        } catch (\Exception $e) {
            return  response()->json([
                "data" => [],
                "message" => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Verificar e validar os campos do envio dos campos
     * @return string[]
     */
    protected function camposObrigatorio()
    {
        return [
            "email" => "required|unique:users|max:255|email",
            "cpf" => "required|unique:users|max:14|regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/",
            "primeiro_nome" => "required|max:255",
            "ultimo_nome" => "required|max:255",
            "endereco" => "required|max:255",
            "bairro" => "required|max:255",
            "numero" => "required|max:255",
            "complemento" => "max:255",
            "cep" => "required|max:9|regex:/^[0-9]{5}-[0-9]{3}$/",
            "password" => "required|min:9",
        ];
    }

    /**
     * Mensagens de Retorno quando a validação pega algum campo
     * @return string[]
     */
    protected function mesagemRetorno()
    {
        return [
            "email.required" => "E-mail é um campo obrigatório",
            "email.email" => "E-mail não se encontra no formato correto",
            "email.max" => "E-mail está acima do limite de caracteres",
            "email.unique" => "E-mail já cadastrado",
            "cpf.unique" => "CPF já cadastrado",
            "cpf.required" => "CPF é obrigatório",
            "cpf.max" => "CPF Inválido",
            "cpf.regex" => "CPF Inválido",
            "primeiro_nome.required" => "Nome Obrigatório",
            "primeiro_nome.max" => "Nome Inválido",
            "ultimo_nome.required" => "Sobrenome Obrigatório",
            "ultimo_nome.max" => "Sobrenome Inválido",
            "endereco.required" => "Endereço Obrigatório",
            "endereco.max" => "Endereço Inválido",
            "bairro.required" => "Bairro Obrigatório",
            "bairro.max" => "Bairro Inválido",
            "numero.required" => "Número Obrigatório",
            "numero.max" => "Número Inválido",
            "complemento.max" => "Complemento Inválido",
            "cep.required" => "CEP Obrigatório",
            "cep.max" => "CEP Inválido",
            "cep.regex" => "CEP Inválido",
            "password.required" => "Senha Obrigatório",
            "password.min" => "Senha Precisa Ter no Mínimo 9 Digitos"
        ];
    }
}
