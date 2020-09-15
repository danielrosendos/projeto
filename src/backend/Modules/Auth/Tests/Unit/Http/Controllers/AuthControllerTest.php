<?php

namespace Modules\Auth\Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Modules\Auth\Entities\Usuarios;
use Modules\Auth\Entities\EnderecoUsuario;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_campo_email_obrigatorio()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "E-mail é um campo obrigatório"
            ];

        $loginData = [
            "email" => "",
            "password" => "123456789"
        ];

        $this->json('POST', 'api/authuser', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_email_invalido_mal_formatado()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "E-mail Inválido"
            ];

        $loginData = [
            "email" => "danielrosendo",
            "password" => "123456789"
        ];

        $this->json('POST', 'api/authuser', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_email_tamanho_maximo()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "E-mail Inválido"
            ];

        $loginData = [
            "email" => "DZAR88b9Zrz6fIOzPSm10wpLJB0ibWHNspZiklf7yyPw63VBRrmeIR0nbv2ELIIoksGLkm3R33GNdlZ0bKbe7reMO1VDaqoIxjMRdXks97kTznuDPe78m1TjvrxxNonZ8yZIXpFOTnYbFouvJcrF9KScAP7tPZtCCOKSFoCf3rkazaUWzMYTwIE9QUdFBjjAA8y21aVXFsO85uaDYAb0j8Xly4yab38xUZ0FYE91hIM0l19svkcFolMPGsPbKTAT@hotmail.com",
            "password" => "123456789"
        ];

        $this->json('POST', 'api/authuser', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_password_obrigatorio()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "Senha Obrigatório"
            ];

        $loginData = [
            "email" => "daniel.rosendos@hotmail.com",
            "password" => ""
        ];

        $this->json('POST', 'api/authuser', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_password_tamanho_maximo()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "Senha Inválida"
            ];

        $loginData = [
            "email" => "daniel.rosendos@hotmail.com",
            "password" => "DZAR88b9Zrz6fIOzPSm10wpLJB0ibWHNspZiklf7yyPw63VBRrmeIR0nbv2ELIIoksGLkm3R33GNdlZ0bKbe7reMO1VDaqoIxjMRdXks97kTznuDPe78m1TjvrxxNonZ8yZIXpFOTnYbFouvJcrF9KScAP7tPZtCCOKSFoCf3rkazaUWzMYTwIE9QUdFBjjAA8y21aVXFsO85uaDYAb0j8Xly4yab38xUZ0FYE91hIM0l19svkcFolMPGsPbKTAT"
        ];

        $this->json('POST', 'api/authuser', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_autenticacao_usuario_nao_existe()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "Usuário ou Senha Inválidos"
            ];

        $loginData = [
            "email" => "daniel.rosendos@hotmail.com",
            "password" => "123456789"
        ];

        $this->json('POST', 'api/authuser', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_autenticacao_senha_invalida()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "Usuário ou Senha Inválidos"
            ];

        $loginData = [
            "email" => "daniel.rosendos@hotmail.com",
            "password" => "12345678925456789"
        ];

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

        factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => "daniel.rosendos@hotmail.com",
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $endereco->id
            ]
        );

        $this->json('POST', 'api/authuser', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }
}
