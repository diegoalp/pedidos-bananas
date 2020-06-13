<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function clientes()
    {
        return view('clientes');
    }

    public function produtos()
    {
        return view('produtos');
    }

    public function novoProduto()
    {
        return view('cadastrar_produto');
    }

    public function funcionarios()
    {
        return view('funcionarios');
    }
}