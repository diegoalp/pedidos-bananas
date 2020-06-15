<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Funcionario extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function usuario(){
        return $this->hasOne('App\User', 'id', 'id_usuario');
    }
}
