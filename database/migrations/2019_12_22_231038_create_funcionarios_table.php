<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cpf');
            $table->string('sexo');
            $table->string('celular');
            $table->string('endereco');
            $table->string('cidade');
            $table->string('bairro');
            $table->string('uf');
            $table->string('cargo');
            $table->string('loja')->nullable();
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funcionarios');
    }
}
