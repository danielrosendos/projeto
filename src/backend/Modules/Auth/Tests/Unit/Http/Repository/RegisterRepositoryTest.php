<?php

namespace Modules\Auth\Tests\Unit\Http\Repository;

use Tests\TestCase;
use Modules\Auth\Entities\Usuarios;
use Modules\Auth\Entities\EnderecoUsuario;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\Http\Repository\RegisterRepository;

class RegisterRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_deve_salvar_com_sucesso_novo_usuario()
    {
        $registerData = [
            "primeiro_nome" => "Daniel",
            "ultimo_nome" => "Rosendo",
            "cpf" => "048.748.603-03",
            "password" => "123456789",
            "endereco" => "Av. josé do patrocinio",
            "bairro" => "Montese",
            "numero" => "1151",
            "complemento" => "Ao lado da loja lindo pet",
            "cep" => "60410-150",
            "email" => "daniel.rosendos3@hotmail.com"
        ];

        $registerRepository = new RegisterRepository();
        $registerRepository->salvar($registerData);

        $this->assertCount(1, Usuarios::all());
        $this->assertCount(1, EnderecoUsuario::all());
    }
}
