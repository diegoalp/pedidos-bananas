@extends('adminlte::page')

@section('title', 'Bananas Café | Clientes')
@foreach ($pedido as $p)
    
@section('content_header')
<h1 class="text-center">PEDIDO Nº {{ $p->codigo }}</h1>
@stop

@section('content')
<div id="app">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-warning card-outline">
                    <div class="card-body box-profile">
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Cliente:</b><br/> <a>{{ $p->cliente->nome }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Funcionário:</b> <br/><a>{{ $p->usuario->name }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Loja:</b> <br/><a>{{ $p->loja }}</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>     
            </div>
            <div class="col-md-9">
            <addproduto-component pedido_id="{{ $p->id }}" pedido_status="{{ $p->status }}"></addproduto-component>
            </div>
        </div>
    </div>
</div>
@stop

@endforeach
<style>
    aside, .navbar-nav{
        display: none !important;
    }.content-wrapper, .main-header{
        margin-left: 0 !important;
    }
</style>