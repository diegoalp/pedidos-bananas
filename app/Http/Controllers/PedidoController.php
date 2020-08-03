<?php

namespace App\Http\Controllers;

use App\Pedido;
use App\Cliente;
use App\Produto;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos = Pedido::with('cliente')->get();
        return json_encode($pedidos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $cliente = (object)$request->input('cliente');
        $qtdPedidos = Pedido::all();
        $dataAtual = new Carbon();
        $data = $dataAtual->format('Ymd');

        if ($qtdPedidos) {
            $codpedido = $data. count($qtdPedidos) + 1;
        } else {
            $codpedido = $data. '1';
        }

        $pedido = new Pedido();
        $pedido->codigo = $codpedido;
        $pedido->valorTotal = 0;
        $pedido->status = 0;
        $pedido->forma_pagamento = 0;
        $pedido->usuario_id = $request->input('usuario');
        $pedido->cliente_id = $cliente->id;
        $pedido->loja = $request->input('loja');

        $pedido->save();

        return response($pedido->codigo);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function show($pedido)
    {
        $pedido = Pedido::with('usuario')
        ->with('cliente')
        ->where('codigo','=', $pedido)->get();
        return view('pedido')->with(['pedido'=>$pedido]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pedido = Pedido::find($id);
        $pedido->status = 1;
        $pedido->valorTotal = $request[0];
        $pedido->save();

        return response(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
