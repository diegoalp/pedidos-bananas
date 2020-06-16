<?php

namespace App\Http\Controllers;

use App\Funcionario;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class FuncionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $funcionarios = Funcionario::with('usuario')->get();
        return json_encode($funcionarios);
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
        $senha = Str::random(8);
        $usuario = new User();
        $usuario->name = mb_strtoupper($request->input('nome'));
        $usuario->email = mb_strtoupper($request->input('email'));
        $usuario->password = Hash::make($senha);
        $usuario->user_type = $request->input('nivel_acesso');
        $usuario->save();

        if($usuario->id){
            $funcionario = new Funcionario();
            $funcionario->cpf = $request->input('cpf');
            $funcionario->sexo = $request->input('sexo');
            $funcionario->celular = $request->input('celular');
            $funcionario->endereco = mb_strtoupper($request->input('endereco'));
            $funcionario->cidade = mb_strtoupper($request->input('cidade'));
            $funcionario->bairro = mb_strtoupper($request->input('bairro'));
            $funcionario->uf = mb_strtoupper($request->input('estado'));
            $funcionario->loja = mb_strtoupper($request->input('loja'));
            $funcionario->cargo = mb_strtoupper($request->input('cargo'));
            $funcionario->id_usuario = $usuario->id;
            $funcionario->save();

            return response($senha);
        }else{
            return response(404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Funcionario  $funcionario
     * @return \Illuminate\Http\Response
     */
    public function show(Funcionario $funcionario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Funcionario  $funcionario
     * @return \Illuminate\Http\Response
     */
    public function edit(Funcionario $funcionario)
    {
        //
    }

    public function attSenha(Request $request, $id)
    {
        $usuario = User::find($id);
        $usuario->password = Hash::make($request->input('novasenha'));
        $usuario->save();

        return response(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Funcionario  $funcionario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Funcionario $funcionario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Funcionario  $funcionario
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $funcionario = Funcionario::find($id);
        $funcionario->delete();
        $funcionario->usuario()->delete();
        return response(200);
    }
}
