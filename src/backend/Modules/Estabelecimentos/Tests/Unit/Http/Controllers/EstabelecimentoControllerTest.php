<?php

namespace Modules\Estabelecimentos\Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Modules\Auth\Entities\Usuarios;
use Modules\Auth\Entities\EnderecoUsuario;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Estabelecimentos\Entities\Estabelecimento;

class EstabelecimentoControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $token;

    protected $user;

    protected $endereco;

    public function test_campo_nome_estabelecimento_obrigatorio()
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

        $this->endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $this->user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $this->endereco->id
            ]
        )->first();

        $this->token = auth('api')->login($this->user);

        $retornoEsperado =
            [
                "data" => [],
                "message" => "Nome Estabelecimento Obrigatório"
            ];

        $registerData = [
            "nome_estabelecimento" => "",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "ao lado da loja lindo pet",
            "cep" => "60410-150",
            "latitude" => "-40.5684",
            "longitude" => "-0.445578"
        ];

        $this->json('POST', 'api/cadastrarnovoestabelecimento', $registerData, ['Accept' => 'application/json', 'Authorization' => "Bearer {$this->token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_nome_estabelecimento_maximo_caracteres()
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

        $this->endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $this->user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $this->endereco->id
            ]
        )->first();

        $this->token = auth('api')->login($this->user);

        $retornoEsperado =
            [
                "data" => [],
                "message" => "Nome Estabelecimento Inválido"
            ];

        $registerData = [
            "nome_estabelecimento" => "DZAR88b9Zrz6fIOzPSm10wpLJB0ibWHNspZiklf7yyPw63VBRrmeIR0nbv2ELIIoksGLkm3R33GNdlZ0bKbe7reMO1VDaqoIxjMRdXks97kTznuDPe78m1TjvrxxNonZ8yZIXpFOTnYbFouvJcrF9KScAP7tPZtCCOKSFoCf3rkazaUWzMYTwIE9QUdFBjjAA8y21aVXFsO85uaDYAb0j8Xly4yab38xUZ0FYE91hIM0l19svkcFolMPGsPbKTAT",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "ao lado da loja lindo pet",
            "cep" => "60410-150",
            "latitude" => "-40.5684",
            "longitude" => "-0.445578"
        ];

        $this->json('POST', 'api/cadastrarnovoestabelecimento', $registerData, ['Accept' => 'application/json', 'Authorization' => "Bearer {$this->token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_endereco_obrigatorio()
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

        $this->endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $this->user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $this->endereco->id
            ]
        )->first();

        $this->token = auth('api')->login($this->user);

        $retornoEsperado =
            [
                "data" => [],
                "message" => "Endereço Obrigatório"
            ];

        $registerData = [
            "nome_estabelecimento" => "Lindo Pet",
            "endereco" => "",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "ao lado da loja lindo pet",
            "cep" => "60410-150",
            "latitude" => "-40.5684",
            "longitude" => "-0.445578"
        ];

        $this->json('POST', 'api/cadastrarnovoestabelecimento', $registerData, ['Accept' => 'application/json', 'Authorization' => "Bearer {$this->token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_endereco_max_caracteres()
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

        $this->endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $this->user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $this->endereco->id
            ]
        )->first();

        $this->token = auth('api')->login($this->user);

        $retornoEsperado =
            [
                "data" => [],
                "message" => "Endereço Inválido"
            ];

        $registerData = [
            "nome_estabelecimento" => "Lindo Pet",
            "endereco" => "DZAR88b9Zrz6fIOzPSm10wpLJB0ibWHNspZiklf7yyPw63VBRrmeIR0nbv2ELIIoksGLkm3R33GNdlZ0bKbe7reMO1VDaqoIxjMRdXks97kTznuDPe78m1TjvrxxNonZ8yZIXpFOTnYbFouvJcrF9KScAP7tPZtCCOKSFoCf3rkazaUWzMYTwIE9QUdFBjjAA8y21aVXFsO85uaDYAb0j8Xly4yab38xUZ0FYE91hIM0l19svkcFolMPGsPbKTAT",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "ao lado da loja lindo pet",
            "cep" => "60410-150",
            "latitude" => "-40.5684",
            "longitude" => "-0.445578"
        ];

        $this->json('POST', 'api/cadastrarnovoestabelecimento', $registerData, ['Accept' => 'application/json', 'Authorization' => "Bearer {$this->token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_bairro_obrigatorio()
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

        $this->endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $this->user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $this->endereco->id
            ]
        )->first();

        $this->token = auth('api')->login($this->user);

        $retornoEsperado =
            [
                "data" => [],
                "message" => "Bairro Obrigatório"
            ];

        $registerData = [
            "nome_estabelecimento" => "Lindo Pet",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "",
            "numero" => "1151",
            "complemento" => "ao lado da loja lindo pet",
            "cep" => "60410-150",
            "latitude" => "-40.5684",
            "longitude" => "-0.445578"
        ];

        $this->json('POST', 'api/cadastrarnovoestabelecimento', $registerData, ['Accept' => 'application/json', 'Authorization' => "Bearer {$this->token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_bairro_max_caracteres()
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

        $this->endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $this->user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $this->endereco->id
            ]
        )->first();

        $this->token = auth('api')->login($this->user);

        $retornoEsperado =
            [
                "data" => [],
                "message" => "Bairro Inválido"
            ];

        $registerData = [
            "nome_estabelecimento" => "Lindo Pet",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "DZAR88b9Zrz6fIOzPSm10wpLJB0ibWHNspZiklf7yyPw63VBRrmeIR0nbv2ELIIoksGLkm3R33GNdlZ0bKbe7reMO1VDaqoIxjMRdXks97kTznuDPe78m1TjvrxxNonZ8yZIXpFOTnYbFouvJcrF9KScAP7tPZtCCOKSFoCf3rkazaUWzMYTwIE9QUdFBjjAA8y21aVXFsO85uaDYAb0j8Xly4yab38xUZ0FYE91hIM0l19svkcFolMPGsPbKTAT",
            "numero" => "1151",
            "complemento" => "ao lado da loja lindo pet",
            "cep" => "60410-150",
            "latitude" => "-40.5684",
            "longitude" => "-0.445578"
        ];

        $this->json('POST', 'api/cadastrarnovoestabelecimento', $registerData, ['Accept' => 'application/json', 'Authorization' => "Bearer {$this->token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_numero_obrigatorio()
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

        $this->endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $this->user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $this->endereco->id
            ]
        )->first();

        $this->token = auth('api')->login($this->user);

        $retornoEsperado =
            [
                "data" => [],
                "message" => "Número Obrigatório"
            ];

        $registerData = [
            "nome_estabelecimento" => "Lindo Pet",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "",
            "complemento" => "ao lado da loja lindo pet",
            "cep" => "60410-150",
            "latitude" => "-40.5684",
            "longitude" => "-0.445578"
        ];

        $this->json('POST', 'api/cadastrarnovoestabelecimento', $registerData, ['Accept' => 'application/json', 'Authorization' => "Bearer {$this->token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_numero_max_caracteres()
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

        $this->endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $this->user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $this->endereco->id
            ]
        )->first();

        $this->token = auth('api')->login($this->user);

        $retornoEsperado =
            [
                "data" => [],
                "message" => "Número Inválido"
            ];

        $registerData = [
            "nome_estabelecimento" => "Lindo Pet",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "DZAR88b9Zrz6fIOzPSm10wpLJB0ibWHNspZiklf7yyPw63VBRrmeIR0nbv2ELIIoksGLkm3R33GNdlZ0bKbe7reMO1VDaqoIxjMRdXks97kTznuDPe78m1TjvrxxNonZ8yZIXpFOTnYbFouvJcrF9KScAP7tPZtCCOKSFoCf3rkazaUWzMYTwIE9QUdFBjjAA8y21aVXFsO85uaDYAb0j8Xly4yab38xUZ0FYE91hIM0l19svkcFolMPGsPbKTAT",
            "complemento" => "ao lado da loja lindo pet",
            "cep" => "60410-150",
            "latitude" => "-40.5684",
            "longitude" => "-0.445578"
        ];

        $this->json('POST', 'api/cadastrarnovoestabelecimento', $registerData, ['Accept' => 'application/json', 'Authorization' => "Bearer {$this->token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_cep_obrigatorio()
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

        $this->endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $this->user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $this->endereco->id
            ]
        )->first();

        $this->token = auth('api')->login($this->user);

        $retornoEsperado =
            [
                "data" => [],
                "message" => "CEP Obrigatório"
            ];

        $registerData = [
            "nome_estabelecimento" => "Lindo Pet",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "ao lado da loja lindo pet",
            "cep" => "",
            "latitude" => "-40.5684",
            "longitude" => "-0.445578"
        ];

        $this->json('POST', 'api/cadastrarnovoestabelecimento', $registerData, ['Accept' => 'application/json', 'Authorization' => "Bearer {$this->token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_cep_max_caracteres()
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

        $this->endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $this->user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $this->endereco->id
            ]
        )->first();

        $this->token = auth('api')->login($this->user);

        $retornoEsperado =
            [
                "data" => [],
                "message" => "CEP Inválido"
            ];

        $registerData = [
            "nome_estabelecimento" => "Lindo Pet",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "ao lado da loja lindo pet",
            "cep" => "60410-1500",
            "latitude" => "-40.5684",
            "longitude" => "-0.445578"
        ];

        $this->json('POST', 'api/cadastrarnovoestabelecimento', $registerData, ['Accept' => 'application/json', 'Authorization' => "Bearer {$this->token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_campo_cep_validador_de_caracteres()
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

        $this->endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $this->user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $this->endereco->id
            ]
        )->first();

        $this->token = auth('api')->login($this->user);

        $retornoEsperado =
            [
                "data" => [],
                "message" => "CEP Inválido"
            ];

        $registerData = [
            "nome_estabelecimento" => "Lindo Pet",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "ao lado da loja lindo pet",
            "cep" => "60.410-150",
            "latitude" => "-40.5684",
            "longitude" => "-0.445578"
        ];

        $this->json('POST', 'api/cadastrarnovoestabelecimento', $registerData, ['Accept' => 'application/json', 'Authorization' => "Bearer {$this->token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_registrar_novo_estabelecimento_com_sucesso()
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

        $this->endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $this->user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $this->endereco->id
            ]
        )->first();

        $this->token = auth('api')->login($this->user);

        $retornoEsperado =
            [
                "data" => [],
                "message" => "Estabelecimento Cadastrado com Sucesso"
            ];

        $registerDataEstabelecimento = [
            "nome_estabelecimento" => "Lindo Pet",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "ao lado da loja lindo pet",
            "cep" => "60410-150",
            "latitude" => "-0.445578",
            "longitude" => "-0.445578"
        ];

        factory(Estabelecimento::class, 1)->create(
            [
                "nome_estabelecimento" => $registerDataEstabelecimento["nome_estabelecimento"],
                "endereco" => $registerDataEstabelecimento["endereco"],
                "bairro" => $registerDataEstabelecimento["bairro"],
                "numero" => $registerDataEstabelecimento["numero"],
                "complemento" => $registerDataEstabelecimento["complemento"],
                "cep" => $registerDataEstabelecimento["cep"],
                "latitude" => $registerDataEstabelecimento["latitude"],
                "longitude" => $registerDataEstabelecimento["longitude"],
                "id_user" => $this->user->id
            ]
        );

        $this->json('POST', 'api/cadastrarnovoestabelecimento', $registerDataEstabelecimento, ['Accept' => 'application/json', 'Authorization' => "Bearer {$this->token}"])
            ->assertStatus(201)
            ->assertJson($retornoEsperado);
    }

    public function test_listagem_de_estabelecimentos_do_usuario()
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

        $this->endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $this->user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $this->endereco->id
            ]
        )->first();

        $this->token = auth('api')->login($this->user);

        $registerDataEstabelecimento = [
            "nome_estabelecimento" => "Lindo Pet",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "ao lado da loja lindo pet",
            "cep" => "60410-150",
            "latitude" => "-0.445578",
            "longitude" => "-0.445578"
        ];

        factory(Estabelecimento::class, 1)->create(
            [
                "nome_estabelecimento" => $registerDataEstabelecimento["nome_estabelecimento"],
                "endereco" => $registerDataEstabelecimento["endereco"],
                "bairro" => $registerDataEstabelecimento["bairro"],
                "numero" => $registerDataEstabelecimento["numero"],
                "complemento" => $registerDataEstabelecimento["complemento"],
                "cep" => $registerDataEstabelecimento["cep"],
                "latitude" => $registerDataEstabelecimento["latitude"],
                "longitude" => $registerDataEstabelecimento["longitude"],
                "id_user" => $this->user->id
            ]
        );

        factory(Estabelecimento::class, 2)->create(
            [
                "nome_estabelecimento" => $registerDataEstabelecimento["nome_estabelecimento"],
                "endereco" => $registerDataEstabelecimento["endereco"],
                "bairro" => $registerDataEstabelecimento["bairro"],
                "numero" => $registerDataEstabelecimento["numero"],
                "complemento" => $registerDataEstabelecimento["complemento"],
                "cep" => $registerDataEstabelecimento["cep"],
                "latitude" => $registerDataEstabelecimento["latitude"],
                "longitude" => $registerDataEstabelecimento["longitude"],
                "id_user" => $this->user->id
            ]
        );

        $response = $this->json('GET', 'api/listarestabelecimentos', [],
            ['Accept' => 'application/json', 'Authorization' => "Bearer {$this->token}"]);

        $retornoEsperado =
            [
                "data" => [
                    "estabelecimentos" => [
                        [
                            "id" => $response["data"]["estabelecimentos"][0]["id"],
                            "nome_estabelecimento" => "Lindo Pet",
                            "endereco" => "Av. josé do patrocinio",
                            "bairro" => "Montese",
                            "numero" => "1151",
                            "complemento" => "ao lado da loja lindo pet",
                            "cep" => "60410-150",
                            "latitude" => "-0.445578",
                            "longitude" => "-0.445578"
                        ],
                        [
                            "id" => $response["data"]["estabelecimentos"][1]["id"],
                            "nome_estabelecimento" => "Lindo Pet",
                            "endereco" => "Av. josé do patrocinio",
                            "bairro" => "Montese",
                            "numero" => "1151",
                            "complemento" => "ao lado da loja lindo pet",
                            "cep" => "60410-150",
                            "latitude" => "-0.445578",
                            "longitude" => "-0.445578",
                        ],
                        [
                            "id" => $response["data"]["estabelecimentos"][2]["id"],
                            "nome_estabelecimento" => "Lindo Pet",
                            "endereco" => "Av. josé do patrocinio",
                            "bairro" => "Montese",
                            "numero" => "1151",
                            "complemento" => "ao lado da loja lindo pet",
                            "cep" => "60410-150",
                            "latitude" => "-0.445578",
                            "longitude" => "-0.445578",
                        ]
                    ]
                ],
                "message" => "Estabelecimentos Consultados Com Sucesso"
            ];


        $response->assertStatus(200)
            ->assertJson($retornoEsperado);
    }

    public function test_quando_usuario_nao_possui_nenhum_estabelecimento_cadastrado()
    {
        $retornoEsperado = [
            "data" => [],
            "message" => "Não há estabelecimentos vinculado ao usuário"
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

        $this->endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $this->user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $this->endereco->id
            ]
        )->first();

        $this->token = auth('api')->login($this->user);

        $this->json('GET', 'api/listarestabelecimentos', [],
            ['Accept' => 'application/json', 'Authorization' => "Bearer {$this->token}"])
            ->assertStatus(404)
            ->assertJson($retornoEsperado);
    }

    public function test_editar_estabelecimento_porem_ele_nao_esta_cadastrado_com_usuario()
    {
        $retornoEsperado = [
            "data" => [],
            "message" => "Não há estabelecimentos vinculado ao usuário"
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

        $this->endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $this->user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $this->endereco->id
            ]
        )->first();

        $this->token = auth('api')->login($this->user);

        $registerDataEstabelecimento = [
            "id" => "sadasdsadsad",
            "nome_estabelecimento" => "Lindo Pet",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "ao lado da loja lindo pet",
            "cep" => "60410-150",
            "latitude" => "-0.445578",
            "longitude" => "-0.445578"
        ];

        $this->json('PUT', 'api/atualizarestabelecimento', $registerDataEstabelecimento,
            ['Accept' => 'application/json', 'Authorization' => "Bearer {$this->token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_editar_com_sucesso()
    {
        $retornoEsperado = [
            "data" => [],
            "message" => "Estabelecimento Editado com Sucesso"
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

        $this->endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $this->user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $this->endereco->id
            ]
        )->first();

        $this->token = auth('api')->login($this->user);

        $registerDataEstabelecimento = [
            "id" => "sadasdsadsad",
            "nome_estabelecimento" => "Lindo Pet",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "ao lado da loja lindo pet",
            "cep" => "60410-150",
            "latitude" => "-0.445578",
            "longitude" => "-0.445578"
        ];

        $estabelecimento = factory(Estabelecimento::class, 1)->create(
            [
                "nome_estabelecimento" => $registerDataEstabelecimento["nome_estabelecimento"],
                "endereco" => $registerDataEstabelecimento["endereco"],
                "bairro" => $registerDataEstabelecimento["bairro"],
                "numero" => $registerDataEstabelecimento["numero"],
                "complemento" => $registerDataEstabelecimento["complemento"],
                "cep" => $registerDataEstabelecimento["cep"],
                "latitude" => $registerDataEstabelecimento["latitude"],
                "longitude" => $registerDataEstabelecimento["longitude"],
                "id_user" => $this->user->id
            ]
        )->first();

        $registerDataEstabelecimento["id"] = $estabelecimento->id;

        $this->json('PUT', 'api/atualizarestabelecimento', $registerDataEstabelecimento,
            ['Accept' => 'application/json', 'Authorization' => "Bearer {$this->token}"])
            ->assertStatus(200)
            ->assertJson($retornoEsperado);
    }

    public function test_deletar_estabelecimento_porem_ele_nao_esta_cadastrado_com_usuario()
    {
        $retornoEsperado = [
            "data" => [],
            "message" => "Não há estabelecimentos vinculado ao usuário"
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

        $this->endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $this->user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $this->endereco->id
            ]
        )->first();

        $this->token = auth('api')->login($this->user);

        $registerDataEstabelecimento = [
            "id" => "sadasdsadsad",
            "nome_estabelecimento" => "Lindo Pet",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "ao lado da loja lindo pet",
            "cep" => "60410-150",
            "latitude" => "-0.445578",
            "longitude" => "-0.445578"
        ];

        $this->json('DELETE', 'api/deletarestabelecimento?id_estabelecimento=21312sdadsadsae1213', $registerDataEstabelecimento,
            ['Accept' => 'application/json', 'Authorization' => "Bearer {$this->token}"])
            ->assertStatus(401)
            ->assertJson($retornoEsperado);
    }

    public function test_deletar_estabelecimento_com_sucesso()
    {
        $retornoEsperado = [
            "data" => [],
            "message" => "Estabelecimento Removido com Sucesso"
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

        $this->endereco = factory(EnderecoUsuario::class, 1)->create(
            [
                "endereco" => $registerData["endereco"],
                "bairro" => $registerData["bairro"],
                "numero" => $registerData["numero"],
                "complemento" => $registerData["complemento"],
                "cep" => $registerData["cep"]
            ]
        )->first();

        $this->user = factory(Usuarios::class, 1)->create(
            [
                "primeiro_nome" => $registerData["primeiro_nome"],
                "ultimo_nome" => $registerData["ultimo_nome"],
                "email" => $registerData["email"],
                "cpf" => $registerData["cpf"],
                "password" => $registerData["password"],
                "id_adress" => $this->endereco->id
            ]
        )->first();

        $this->token = auth('api')->login($this->user);

        $registerDataEstabelecimento = [
            "id" => "sadasdsadsad",
            "nome_estabelecimento" => "Lindo Pet",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "ao lado da loja lindo pet",
            "cep" => "60410-150",
            "latitude" => "-0.445578",
            "longitude" => "-0.445578"
        ];

        $estabelecimento = factory(Estabelecimento::class, 1)->create(
            [
                "nome_estabelecimento" => $registerDataEstabelecimento["nome_estabelecimento"],
                "endereco" => $registerDataEstabelecimento["endereco"],
                "bairro" => $registerDataEstabelecimento["bairro"],
                "numero" => $registerDataEstabelecimento["numero"],
                "complemento" => $registerDataEstabelecimento["complemento"],
                "cep" => $registerDataEstabelecimento["cep"],
                "latitude" => $registerDataEstabelecimento["latitude"],
                "longitude" => $registerDataEstabelecimento["longitude"],
                "id_user" => $this->user->id
            ]
        )->first();

        $this->json('DELETE', "api/deletarestabelecimento?id_estabelecimento={$estabelecimento->id}", $registerDataEstabelecimento,
            ['Accept' => 'application/json', 'Authorization' => "Bearer {$this->token}"])
            ->assertStatus(200)
            ->assertJson($retornoEsperado);
    }
}
