<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function usuario(){
        return $this->hasOne('App\User', 'id', 'usuario_id');
    }

    public function cliente(){
        return $this->hasOne('App\Cliente', 'id', 'cliente_id');
    }

    public function produto(){
        return $this->belongsTo('App\PedidoProduto', 'id', 'pedido_id');
    }
}
