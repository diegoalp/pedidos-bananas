<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware(['auth'])->group(function () {

Route::get('/', 'HomeController@index')->name('home');
Route::get('/clientes', 'HomeController@clientes')->name('clientes');
Route::get('/produtos', 'HomeController@produtos')->name('produtos');
Route::get('/produto/novo', 'HomeController@novoProduto')->name('novo-produto');
Route::get('/funcionarios', 'HomeController@funcionarios')->name('funcionarios');
Route::get('/pedidos', 'HomeController@pedidos')->name('pedidos');


Route::get('/listaclientes', 'ClienteController@index');
Route::post('/cliente/novo', 'ClienteController@store');
Route::delete('/cliente/{id}', 'ClienteController@destroy');

Route::get('/listafuncionarios', 'FuncionarioController@index');
Route::post('/funcionario/novo', 'FuncionarioController@store');
Route::delete('/funcionario/{id}', 'FuncionarioController@destroy');
Route::post('/funcionario/attsenha/{id}','FuncionarioController@attSenha');

Route::get('/listaprodutos', 'ProdutoController@index');
Route::post('/produto/novo', 'ProdutoController@store');
Route::post('/attproduto/{id}', 'ProdutoController@update');
Route::delete('/produto/{id}', 'ProdutoController@destroy');

Route::post('/categoria/nova', 'CategoriaController@store');
Route::get('/listacategorias', 'CategoriaController@index');

Route::get('/listapedidos','PedidoController@index');
Route::get('/pedido/{codigo}','PedidoController@show');
Route::post('/pedido/novo','PedidoController@store');
Route::post('/pedido/{id}','PedidoController@update');


Route::post('/pedido/addproduto','PedidoProdutoController@store');
Route::get('/pedido/produtos/{id}','PedidoProdutoController@show');
Route::delete('/pedido/produtos/{id}','PedidoProdutoController@destroy');
Route::post('/pedido/attproduto/{id}','PedidoProdutoController@update');

});