<?php

namespace Modules\Auth\Entities;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuarios extends Authenticatable implements JWTSubject
{
    use Uuids;

    protected $table = 'users';

    protected $fillable = [
        'id',
        'primeiro_nome',
        'ultimo_nome',
        'email',
        'cpf',
        'password',
        'id_adress'
    ];

    protected $hidden = ['password', 'created_at', 'updated_at', 'id', 'email'];

    public function user_adress()
    {
        return $this->hasOne(EnderecoUsuario::class, 'id', 'id_adress');
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [
            'email' => $this->email,
            "id" => $this->id
        ];
    }
}
