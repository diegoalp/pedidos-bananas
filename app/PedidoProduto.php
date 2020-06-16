<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PedidoProduto extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function pedido(){
        return $this->hasOne('App\Pedido', 'id', 'pedido_id');
    }

    public function produto(){
        return $this->hasOne('App\Produto', 'id', 'produto_id');
    }
}
