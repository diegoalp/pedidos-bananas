@extends('adminlte::page')
@section ('title', 'Dashboard | Bananas')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @can('isAdmin')
            Você é administrador
        @endcan
        @can('isFuncionario')
            Você é funcionário
        @endcan
    </div>
</div>
@endsection
