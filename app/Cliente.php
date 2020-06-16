<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function pedido(){
        return $this->belongsTo('App\Pedido', 'id', 'cliente_id');
    }
}
