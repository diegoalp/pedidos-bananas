<?php

namespace App\Http\Controllers;

use App\Pagamento;
use App\PagamentoPedido;
use App\Pedido;
use Illuminate\Http\Request;

class PagamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagamentos = Pagamento::all();

        return json_encode($pagamentos);
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
        $usuario = \Auth::user();
        $cliente = (object)$request->cliente['id'];
        $pagamento = new Pagamento();
        $pagamento->usuario_id = $usuario->id;
        $pagamento->cliente_id = $request->input('cliente')['id'];
        $pagamento->valor = $request->valor_total;
        $pagamento->forma_pagamento = $request->forma_pagamento;
        $pagamento->save();

        if($pagamento->id){
            foreach($request->pedidos as $p){
                $pagped = new PagamentoPedido();
                $pagped->pagamento_id = $pagamento->id;
                $pagped->pedido_id = $p['id'];
                $pagped->save();

                $pedido = Pedido::find($p['id']);
                $pedido->status = 2;
                $pedido->update();
            }
        }

        return response(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pagamento  $pagamento
     * @return \Illuminate\Http\Response
     */
    public function show(Pagamento $pagamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pagamento  $pagamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Pagamento $pagamento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pagamento  $pagamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pagamento $pagamento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pagamento  $pagamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pagamento $pagamento)
    {
        //
    }
}
