<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::all();
        return json_encode($clientes);
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
            $cliente = new Cliente();
            $cliente->nome = mb_strtoupper($request->input('nome'));
            $cliente->cpf = $request->input('cpf');
            $cliente->sexo = mb_strtoupper($request->input('sexo'));
            $cliente->celular = $request->input('celular');
            $cliente->email = mb_strtoupper($request->input('email'));
            $cliente->endereco = mb_strtoupper($request->input('endereco'));
            $cliente->cidade = mb_strtoupper($request->input('cidade'));
            $cliente->bairro = mb_strtoupper($request->input('bairro'));
            $cliente->uf = mb_strtoupper($request->input('estado'));
            $cliente->local_trabalho = mb_strtoupper($request->input('trabalho'));
            $cliente->apelido = mb_strtoupper($request->input('apelido'));
            $cliente->status = 1;
            $cliente->funcao = mb_strtoupper($request->input('funcao'));
            $cliente->save();
            return response(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        $cliente = Cliente::find($id);
        return json_decode($cliente);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        $cliente = Cliente::find($id);
        $cliente->nome = mb_strtoupper($request->input('nome'));
        $cliente->cpf = $request->input('cpf');
        $cliente->sexo = mb_strtoupper($request->input('sexo'));
        $cliente->telefone = $request->input('telefone');
        $cliente->celular = $request->input('celular');
        $cliente->email = mb_strtoupper($request->input('email'));
        $cliente->endereco = $request->input('endereco');
        $cliente->cidade = mb_strtoupper($request->input('cidade'));
        $cliente->bairro = mb_strtoupper($request->input('bairro'));
        $cliente->uf = mb_strtoupper($request->input('estado'));
        $cliente->local_trabalho = mb_strtoupper($request->input('trabalho'));
        $cliente->apelido = mb_strtoupper($request->input('apelido'));
        $cliente->status = $request->input('status');;
        $cliente->funcao = $request->input('funcao');
        
        $cliente->save();
        
        return response(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        $cliente->delete();
        return response(200);
    }
}
