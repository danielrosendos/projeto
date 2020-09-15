<?php

namespace Modules\Auth\Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Modules\Auth\Entities\Usuarios;
use Modules\Auth\Entities\EnderecoUsuario;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_campo_email_obrigatorio()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "E-mail é um campo obrigatório"
            ];

        $this->json('POST', 'api/registeruser', ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_email_formato_errado()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "E-mail não se encontra no formato correto"
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
            "email" => "daasidsd"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_email_nao_passar_de_max_caracteres()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "E-mail está acima do limite de caracteres"
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
            "email" => "DZAR88b9Zrz6fIOzPSm10wpLJB0ibWHNspZiklf7yyPw63VBRrmeIR0nbv2ELIIoksGLkm3R33GNdlZ0bKbe7reMO1VDaqoIxjMRdXks97kTznuDPe78m1TjvrxxNonZ8yZIXpFOTnYbFouvJcrF9KScAP7tPZtCCOKSFoCf3rkazaUWzMYTwIE9QUdFBjjAA8y21aVXFsO85uaDYAb0j8Xly4yab38xUZ0FYE91hIM0l19svkcFolMPGsPbKTAT@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_email_ja_cadastrado_nao_unico()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "E-mail já cadastrado"
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
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $endereco->id
            ]
        );

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_cpf_unico()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "CPF já cadastrado"
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
            "email" => "daniel.rosendos2@hotmail.com"
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

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_cpf_e_obrigatorio()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "CPF é obrigatório"
            ];

        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => " Rosendo",
            "cpf" => "",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos2@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_cpf_nao_passar_do_maximo_caracteres()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "CPF Inválido"
            ];

        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => " Rosendo",
            "cpf" => "048.748.593-999999999",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos2@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_primeiro_nome_obrigatorio()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "Nome Obrigatório"
            ];

        $registerData = [
            "primeiro_nome" => "",
            "ultimo_nome" => " Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos2@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_primeiro_nome_nao_passar_do_tamanho_maximo()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "Nome Inválido"
            ];

        $registerData = [
            "primeiro_nome" => "DZAR88b9Zrz6fIOzPSm10wpLJB0ibWHNspZiklf7yyPw63VBRrmeIR0nbv2ELIIoksGLkm3R33GNdlZ0bKbe7reMO1VDaqoIxjMRdXks97kTznuDPe78m1TjvrxxNonZ8yZIXpFOTnYbFouvJcrF9KScAP7tPZtCCOKSFoCf3rkazaUWzMYTwIE9QUdFBjjAA8y21aVXFsO85uaDYAb0j8Xly4yab38xUZ0FYE91hIM0l19svkcFolMPGsPbKTAT",
            "ultimo_nome" => " Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos2@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_ultimo_nome_obrigatorio()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "Sobrenome Obrigatório"
            ];

        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => " ",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos2@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_ultimo_nome_nao_passar_do_tamanho_maximo()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "Sobrenome Inválido"
            ];

        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "DZAR88b9Zrz6fIOzPSm10wpLJB0ibWHNspZiklf7yyPw63VBRrmeIR0nbv2ELIIoksGLkm3R33GNdlZ0bKbe7reMO1VDaqoIxjMRdXks97kTznuDPe78m1TjvrxxNonZ8yZIXpFOTnYbFouvJcrF9KScAP7tPZtCCOKSFoCf3rkazaUWzMYTwIE9QUdFBjjAA8y21aVXFsO85uaDYAb0j8Xly4yab38xUZ0FYE91hIM0l19svkcFolMPGsPbKTAT",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos2@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_endereco_obrigatorio()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "Endereço Obrigatório"
            ];

        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos2@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_endereco_nao_passar_do_tamanho_maximo()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "Endereço Inválido"
            ];

        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "DZAR88b9Zrz6fIOzPSm10wpLJB0ibWHNspZiklf7yyPw63VBRrmeIR0nbv2ELIIoksGLkm3R33GNdlZ0bKbe7reMO1VDaqoIxjMRdXks97kTznuDPe78m1TjvrxxNonZ8yZIXpFOTnYbFouvJcrF9KScAP7tPZtCCOKSFoCf3rkazaUWzMYTwIE9QUdFBjjAA8y21aVXFsO85uaDYAb0j8Xly4yab38xUZ0FYE91hIM0l19svkcFolMPGsPbKTAT",
            "bairro" => "montese",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos2@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_bairro_obrigatorio()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "Bairro Obrigatório"
            ];

        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos2@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_bairro_nao_passar_do_tamanho_maximo()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "Bairro Inválido"
            ];

        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "DZAR88b9Zrz6fIOzPSm10wpLJB0ibWHNspZiklf7yyPw63VBRrmeIR0nbv2ELIIoksGLkm3R33GNdlZ0bKbe7reMO1VDaqoIxjMRdXks97kTznuDPe78m1TjvrxxNonZ8yZIXpFOTnYbFouvJcrF9KScAP7tPZtCCOKSFoCf3rkazaUWzMYTwIE9QUdFBjjAA8y21aVXFsO85uaDYAb0j8Xly4yab38xUZ0FYE91hIM0l19svkcFolMPGsPbKTAT",
            "numero" => "1151",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos2@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_numero_obrigatorio()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "Número Obrigatório"
            ];

        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos2@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_numero_nao_passar_do_tamanho_maximo()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "Número Inválido"
            ];

        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "DZAR88b9Zrz6fIOzPSm10wpLJB0ibWHNspZiklf7yyPw63VBRrmeIR0nbv2ELIIoksGLkm3R33GNdlZ0bKbe7reMO1VDaqoIxjMRdXks97kTznuDPe78m1TjvrxxNonZ8yZIXpFOTnYbFouvJcrF9KScAP7tPZtCCOKSFoCf3rkazaUWzMYTwIE9QUdFBjjAA8y21aVXFsO85uaDYAb0j8Xly4yab38xUZ0FYE91hIM0l19svkcFolMPGsPbKTAT",
            "complemento" => "Ao lado da padaria piamarta",
            "cep" => "60410-150",
            "email" => "daniel.rosendos2@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_complemento_nao_passar_do_tamanho_maximo()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "Complemento Inválido"
            ];

        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "DZAR88b9Zrz6fIOzPSm10wpLJB0ibWHNspZiklf7yyPw63VBRrmeIR0nbv2ELIIoksGLkm3R33GNdlZ0bKbe7reMO1VDaqoIxjMRdXks97kTznuDPe78m1TjvrxxNonZ8yZIXpFOTnYbFouvJcrF9KScAP7tPZtCCOKSFoCf3rkazaUWzMYTwIE9QUdFBjjAA8y21aVXFsO85uaDYAb0j8Xly4yab38xUZ0FYE91hIM0l19svkcFolMPGsPbKTAT",
            "cep" => "60410-150",
            "email" => "daniel.rosendos2@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_cpf_testar_regex_validacao()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "CPF Inválido"
            ];

        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "cpf" => "048.748..593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "Ao lado da loja lindo pet",
            "cep" => "60410-150",
            "email" => "daniel.rosendos2@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_cep_obrigatorio()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "CEP Obrigatório"
            ];

        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "Ao lado da loja lindo pet",
            "cep" => "",
            "email" => "daniel.rosendos2@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_cep_nao_passar_do_tamanho_maximo()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "CEP Inválido"
            ];

        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "Ao lado da loja lindo pet",
            "cep" => "60410-1500",
            "email" => "daniel.rosendos2@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_cep_regex_validacao()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "CEP Inválido"
            ];

        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "Ao lado da loja lindo pet",
            "cep" => "60410150",
            "email" => "daniel.rosendos2@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
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

        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "Ao lado da loja lindo pet",
            "cep" => "60410-150",
            "email" => "daniel.rosendos2@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_password_no_min_nove_digitos()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "Senha Precisa Ter no Mínimo 9 Digitos"
            ];

        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "12345678",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "Ao lado da loja lindo pet",
            "cep" => "60410-150",
            "email" => "daniel.rosendos2@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson($retornoEsperado);
    }

    public function test_retorno_criacao_usuario_sucesso()
    {
        $retornoEsperado =
            [
                "data" => [],
                "message" => "Usuário Cadastrado Com Sucesso"
            ];

        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "cpf" => "048.748.593-99",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "Ao lado da loja lindo pet",
            "cep" => "60410-150",
            "email" => "daniel.rosendos@hotmail.com"
        ];

        $this->json('POST', 'api/registeruser', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJson($retornoEsperado);
    }
}
