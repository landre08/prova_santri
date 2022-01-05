<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autorizacao extends Model
{
    protected $table = 'autorizacoes';

    public $timestamps = false;
    protected $primaryKey = 'USUARIO_ID';
}
