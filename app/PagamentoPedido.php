<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagamentoPedido extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function pagamento(){
        return $this->hasOne('App\Pagamento', 'id', 'pagamento_id');
    }

    public function pedido(){
        return $this->hasOne('App\Pedido', 'id', 'pedido_id');
    }
}
