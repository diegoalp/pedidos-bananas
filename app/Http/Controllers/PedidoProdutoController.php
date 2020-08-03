<?php

namespace App\Http\Controllers;

use App\PedidoProduto;
use Illuminate\Http\Request;

class PedidoProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, $id)
    {
        $produto = (object)$request->input('produto');
        $prod = new PedidoProduto();
        $prod->quantidade = $request->input('quantidade');
        $prod->valor = $produto->valor;
        $prod->total = $request->input('quantidade') * $produto->valor;
        $prod->produto_id = $produto->id;
        $prod->pedido_id = $id;

        $prod->save();

        return response(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PedidoProduto  $pedidoProduto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produtos = PedidoProduto::with('produto')->where('pedido_id', $id)->orderBy('id', 'desc')->get();
        return json_encode($produtos);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PedidoProduto  $pedidoProduto
     * @return \Illuminate\Http\Response
     */
    public function edit(PedidoProduto $pedidoProduto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PedidoProduto  $pedidoProduto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pedidoProduto = PedidoProduto::find($id);
        if( $request[0] == 0){
            $pedidoProduto->delete();

            return response(200);

        }else{
            $pedidoProduto->quantidade = $request[0];
            $pedidoProduto->total = $pedidoProduto->valor * $request[0];
            $pedidoProduto->save();

        return response(200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PedidoProduto  $pedidoProduto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pedidoProduto = PedidoProduto::find($id);
        $pedidoProduto->delete();
        return \response(200);
    }
}
