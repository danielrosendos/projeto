<?php

namespace Modules\Auth\Entities;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class EnderecoUsuario extends Model
{
    use Uuids;

    protected $table = 'user_address';

    protected $fillable = [
        'id',
        'endereco',
        'bairro',
        'numero',
        'complemento',
        'cep'
    ];

    protected $hidden = ['created_at', 'updated_at', 'id'];

    public function user_adress()
    {
        return $this->hasOne(EnderecoUsuario::class, 'id', 'id_adress');
    }
}
