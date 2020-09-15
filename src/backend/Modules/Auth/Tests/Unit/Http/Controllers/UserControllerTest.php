<?php

namespace Modules\Auth\Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Modules\Auth\Entities\Usuarios;
use Modules\Auth\Entities\EnderecoUsuario;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_deve_recusar_quando_token_nao_informado()
    {
        $retornoEsperado =
            [
                "status" => "Token Não Informado"
            ];

        $this->json('GET', 'api/infouser', ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_deve_recusar_quando_token_e_invalido()
    {
        $retornoEsperado =
            [
                "status" => "Token Inválido"
            ];

        $this->json('GET', 'api/infouser', [], ['Accept' => 'application/json', 'Authorization' => "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpYXQiOjE1OTkwMTg0ODIsImV4cCI6MTU5OTEwNDg4Miwic3ViIjoiYjA1YzIwMGItN2FlOC00OWE3LWFhY2QtMjljYTcyZGRmMTBlIn0.Ob72S_JsJZXfFRi2ReNEeuLMXaiUPHWZft19d0-payU"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_deve_testar_estrutura_retorno_ao_pegar_informacoes_do_usuario()
    {
        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => " Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos@hotmail.com"
        ];

        $endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $endereco->id
            ]
        )->first();

        $token = auth('api')->login($user);

        $retornoEsperado = [
            "data" => [
                "primeiro_nome" => "Daniel",
                "ultimo_nome" => " Rosendo",
                "cpf" => "048.748.593-99",
                "id_adress" => $user->id_adress,
                "user_adress" => [
                    "endereco" => "Av. josé do patrocinio",
                    "bairro" => "montese",
                    "numero" => "1151",
                    "complemento" => "Ao lado da padaria piamarta",
                    "cep" => "60410-150"
                ]
            ],
            "message" => "Dados Consultados Com Sucesso"
        ];

        $this->json('GET', 'api/infouser', [], ['Accept' => 'application/json', 'Authorization' => "Bearer {$token}"])
            ->assertStatus(200)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_primeiro_nome_obrigatorio()
    {
        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => " Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos@hotmail.com"
        ];

        $endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $endereco->id
            ]
        )->first();

        $token = auth('api')->login($user);

        $retornoEsperado = [
            "data" => [],
            "message" => "Nome é Obrigatório"
        ];

        $dados = [
            "primeiro_nome" => "",
            "ultimo_nome" => " Rosendo",
            "user_adress" => [
                "endereco" => "Av. josé do patrocinio",
                "bairro" => "montese",
                "numero" => "1151",
                "complemento" => "Ao lado da padaria piamarta",
                "cep" => "60410-150"
            ]
        ];

        $this->json('PUT', 'api/updateinfouser', $dados, ['Accept' => 'application/json', 'Authorization' => "Bearer {$token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_primeiro_nome_tamanho_max_caracteres()
    {
        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => " Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos@hotmail.com"
        ];

        $endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $endereco->id
            ]
        )->first();

        $token = auth('api')->login($user);

        $retornoEsperado = [
            "data" => [],
            "message" => "Nome Inválido"
        ];

        $dados = [
            "primeiro_nome" => "DZAR88b9Zrz6fIOzPSm10wpLJB0ibWHNspZiklf7yyPw63VBRrmeIR0nbv2ELIIoksGLkm3R33GNdlZ0bKbe7reMO1VDaqoIxjMRdXks97kTznuDPe78m1TjvrxxNonZ8yZIXpFOTnYbFouvJcrF9KScAP7tPZtCCOKSFoCf3rkazaUWzMYTwIE9QUdFBjjAA8y21aVXFsO85uaDYAb0j8Xly4yab38xUZ0FYE91hIM0l19svkcFolMPGsPbKTAT",
            "ultimo_nome" => " Rosendo",
            "user_adress" => [
                "endereco" => "Av. josé do patrocinio",
                "bairro" => "montese",
                "numero" => "1151",
                "complemento" => "Ao lado da padaria piamarta",
                "cep" => "60410-150"
            ]
        ];

        $this->json('PUT', 'api/updateinfouser', $dados, ['Accept' => 'application/json', 'Authorization' => "Bearer {$token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_ultimo_nome_obrigatorio()
    {
        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => " Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos@hotmail.com"
        ];

        $endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $endereco->id
            ]
        )->first();

        $token = auth('api')->login($user);

        $retornoEsperado = [
            "data" => [],
            "message" => "Sobrenome é Obrigatório"
        ];

        $dados = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "",
            "user_adress" => [
                "endereco" => "Av. josé do patrocinio",
                "bairro" => "montese",
                "numero" => "1151",
                "complemento" => "Ao lado da padaria piamarta",
                "cep" => "60410-150"
            ]
        ];

        $this->json('PUT', 'api/updateinfouser', $dados, ['Accept' => 'application/json', 'Authorization' => "Bearer {$token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_ultimo_nome_tamanho_max_caracteres()
    {
        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => " Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos@hotmail.com"
        ];

        $endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $endereco->id
            ]
        )->first();

        $token = auth('api')->login($user);

        $retornoEsperado = [
            "data" => [],
            "message" => "Sobrenome Inválido"
        ];

        $dados = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => " DZAR88b9Zrz6fIOzPSm10wpLJB0ibWHNspZiklf7yyPw63VBRrmeIR0nbv2ELIIoksGLkm3R33GNdlZ0bKbe7reMO1VDaqoIxjMRdXks97kTznuDPe78m1TjvrxxNonZ8yZIXpFOTnYbFouvJcrF9KScAP7tPZtCCOKSFoCf3rkazaUWzMYTwIE9QUdFBjjAA8y21aVXFsO85uaDYAb0j8Xly4yab38xUZ0FYE91hIM0l19svkcFolMPGsPbKTAT",
            "user_adress" => [
                "endereco" => "Av. josé do patrocinio",
                "bairro" => "montese",
                "numero" => "1151",
                "complemento" => "Ao lado da padaria piamarta",
                "cep" => "60410-150"
            ]
        ];

        $this->json('PUT', 'api/updateinfouser', $dados, ['Accept' => 'application/json', 'Authorization' => "Bearer {$token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_user_adress_obrigatorio()
    {
        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => " Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos@hotmail.com"
        ];

        $endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $endereco->id
            ]
        )->first();

        $token = auth('api')->login($user);

        $retornoEsperado = [
            "data" => [],
            "message" => "Endereço é Obrigatório"
        ];

        $dados = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "user_adress" => ""
        ];

        $this->json('PUT', 'api/updateinfouser', $dados, ['Accept' => 'application/json', 'Authorization' => "Bearer {$token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_user_adress_endereco_obrigatorio()
    {
        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => " Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos@hotmail.com"
        ];

        $endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $endereco->id
            ]
        )->first();

        $token = auth('api')->login($user);

        $retornoEsperado = [
            "data" => [],
            "message" => "Endereço Inválido"
        ];

        $dados = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "user_adress" => [
                "endereco" => "",
                "bairro" => "montese",
                "numero" => "1151",
                "complemento" => "Ao lado da padaria piamarta",
                "cep" => "60410-150"
            ]
        ];

        $this->json('PUT', 'api/updateinfouser', $dados, ['Accept' => 'application/json', 'Authorization' => "Bearer {$token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_user_adress_endereco_tamanho_maximo()
    {
        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => " Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos@hotmail.com"
        ];

        $endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $endereco->id
            ]
        )->first();

        $token = auth('api')->login($user);

        $retornoEsperado = [
            "data" => [],
            "message" => "Endereço Inválido"
        ];

        $dados = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "user_adress" => [
                "endereco" => "DZAR88b9Zrz6fIOzPSm10wpLJB0ibWHNspZiklf7yyPw63VBRrmeIR0nbv2ELIIoksGLkm3R33GNdlZ0bKbe7reMO1VDaqoIxjMRdXks97kTznuDPe78m1TjvrxxNonZ8yZIXpFOTnYbFouvJcrF9KScAP7tPZtCCOKSFoCf3rkazaUWzMYTwIE9QUdFBjjAA8y21aVXFsO85uaDYAb0j8Xly4yab38xUZ0FYE91hIM0l19svkcFolMPGsPbKTAT",
                "bairro" => "montese",
                "numero" => "1151",
                "complemento" => "Ao lado da padaria piamarta",
                "cep" => "60410-150"
            ]
        ];

        $this->json('PUT', 'api/updateinfouser', $dados, ['Accept' => 'application/json', 'Authorization' => "Bearer {$token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_user_adress_bairro_obrigatorio()
    {
        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => " Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos@hotmail.com"
        ];

        $endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $endereco->id
            ]
        )->first();

        $token = auth('api')->login($user);

        $retornoEsperado = [
            "data" => [],
            "message" => "Bairro Inválido"
        ];

        $dados = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "user_adress" => [
                "endereco" => "Av. josé do patrocinio",
                "bairro" => "",
                "numero" => "1151",
                "complemento" => "Ao lado da padaria piamarta",
                "cep" => "60410-150"
            ]
        ];

        $this->json('PUT', 'api/updateinfouser', $dados, ['Accept' => 'application/json', 'Authorization' => "Bearer {$token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_user_adress_bairro_tamanho_maximo()
    {
        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => " Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos@hotmail.com"
        ];

        $endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $endereco->id
            ]
        )->first();

        $token = auth('api')->login($user);

        $retornoEsperado = [
            "data" => [],
            "message" => "Bairro Inválido"
        ];

        $dados = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "user_adress" => [
                "endereco" => "Av. josé do patrocinio",
                "bairro" => "DZAR88b9Zrz6fIOzPSm10wpLJB0ibWHNspZiklf7yyPw63VBRrmeIR0nbv2ELIIoksGLkm3R33GNdlZ0bKbe7reMO1VDaqoIxjMRdXks97kTznuDPe78m1TjvrxxNonZ8yZIXpFOTnYbFouvJcrF9KScAP7tPZtCCOKSFoCf3rkazaUWzMYTwIE9QUdFBjjAA8y21aVXFsO85uaDYAb0j8Xly4yab38xUZ0FYE91hIM0l19svkcFolMPGsPbKTAT",
                "numero" => "1151",
                "complemento" => "Ao lado da padaria piamarta",
                "cep" => "60410-150"
            ]
        ];

        $this->json('PUT', 'api/updateinfouser', $dados, ['Accept' => 'application/json', 'Authorization' => "Bearer {$token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_user_adress_numero_obrigatorio()
    {
        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => " Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos@hotmail.com"
        ];

        $endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $endereco->id
            ]
        )->first();

        $token = auth('api')->login($user);

        $retornoEsperado = [
            "data" => [],
            "message" => "Número Inválido"
        ];

        $dados = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "user_adress" => [
                "endereco" => "Av. josé do patrocinio",
                "bairro" => "Montese",
                "numero" => "",
                "complemento" => "Ao lado da padaria piamarta",
                "cep" => "60410-150"
            ]
        ];

        $this->json('PUT', 'api/updateinfouser', $dados, ['Accept' => 'application/json', 'Authorization' => "Bearer {$token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_user_adress_numero_tamanho_maximo()
    {
        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => " Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos@hotmail.com"
        ];

        $endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $endereco->id
            ]
        )->first();

        $token = auth('api')->login($user);

        $retornoEsperado = [
            "data" => [],
            "message" => "Número Inválido"
        ];

        $dados = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "user_adress" => [
                "endereco" => "Av. josé do patrocinio",
                "bairro" => "Montese",
                "numero" => "DZAR88b9Zrz6fIOzPSm10wpLJB0ibWHNspZiklf7yyPw63VBRrmeIR0nbv2ELIIoksGLkm3R33GNdlZ0bKbe7reMO1VDaqoIxjMRdXks97kTznuDPe78m1TjvrxxNonZ8yZIXpFOTnYbFouvJcrF9KScAP7tPZtCCOKSFoCf3rkazaUWzMYTwIE9QUdFBjjAA8y21aVXFsO85uaDYAb0j8Xly4yab38xUZ0FYE91hIM0l19svkcFolMPGsPbKTAT",
                "complemento" => "Ao lado da padaria piamarta",
                "cep" => "60410-150"
            ]
        ];

        $this->json('PUT', 'api/updateinfouser', $dados, ['Accept' => 'application/json', 'Authorization' => "Bearer {$token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_user_adress_cep_obrigatorio()
    {
        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => " Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos@hotmail.com"
        ];

        $endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $endereco->id
            ]
        )->first();

        $token = auth('api')->login($user);

        $retornoEsperado = [
            "data" => [],
            "message" => "CEP Inválido"
        ];

        $dados = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "user_adress" => [
                "endereco" => "Av. josé do patrocinio",
                "bairro" => "Montese",
                "numero" => "1151",
                "complemento" => "Ao lado da padaria piamarta",
                "cep" => ""
            ]
        ];

        $this->json('PUT', 'api/updateinfouser', $dados, ['Accept' => 'application/json', 'Authorization' => "Bearer {$token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_user_adress_cep_tamanho_maximo()
    {
        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => " Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos@hotmail.com"
        ];

        $endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $endereco->id
            ]
        )->first();

        $token = auth('api')->login($user);

        $retornoEsperado = [
            "data" => [],
            "message" => "CEP Inválido"
        ];

        $dados = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "user_adress" => [
                "endereco" => "Av. josé do patrocinio",
                "bairro" => "Montese",
                "numero" => "1151",
                "complemento" => "Ao lado da padaria piamarta",
                "cep" => "60410-1509"
            ]
        ];

        $this->json('PUT', 'api/updateinfouser', $dados, ['Accept' => 'application/json', 'Authorization' => "Bearer {$token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_user_adress_cep_tamanho_regex()
    {
        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => " Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos@hotmail.com"
        ];

        $endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $endereco->id
            ]
        )->first();

        $token = auth('api')->login($user);

        $retornoEsperado = [
            "data" => [],
            "message" => "CEP Inválido"
        ];

        $dados = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "user_adress" => [
                "endereco" => "Av. josé do patrocinio",
                "bairro" => "Montese",
                "numero" => "1151",
                "complemento" => "Ao lado da padaria piamarta",
                "cep" => "60.410-150"
            ]
        ];

        $this->json('PUT', 'api/updateinfouser', $dados, ['Accept' => 'application/json', 'Authorization' => "Bearer {$token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_deve_testar_quando_um_update_ocorrer_tudo_bem()
    {

        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => " Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos@hotmail.com"
        ];

        $endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $endereco->id
            ]
        )->first();

        $token = auth('api')->login($user);

        $retornoEsperado = [
            "data" => [],
            "message" => "Dados Alterados Com Sucesso"
        ];

        $dados = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "user_adress" => [
                "endereco" => "Av. josé do patrocinio",
                "bairro" => "Montese",
                "numero" => "1151",
                "complemento" => "Ao lado da padaria piamarta",
                "cep" => "60410-150"
            ]
        ];

        $this->json('PUT', 'api/updateinfouser', $dados, ['Accept' => 'application/json', 'Authorization' => "Bearer {$token}"])
            ->assertStatus(200)
            ->assertJson($retornoEsperado);
    }
}
