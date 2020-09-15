<?php

namespace Modules\Estabelecimentos\Entities;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Estabelecimento extends Model
{
    use Uuids;

    protected $table = 'estabelecimento';

    protected $fillable = [
        "id",
        "nome_estabelecimento",
        "endereco",
        "bairro",
        "numero",
        "complemento",
        "cep",
        "latitude",
        "longitude",
        "id_user"
    ];

    protected $hidden = ["id_user", "created_at", "updated_at"];
}
