<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financeiro_fornecedores', function (Blueprint $table) {
            $table->id();
            $table->string('cpfcnpj', 100);
            $table->string('nome', 191)->nullable();
            $table->string('email', 100);
            $table->string('site', 100)->nullable();
            $table->string('cep', 8);
            $table->string('logradouro', 100)->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro', 100)->nullable();
            $table->string('cidade', 100)->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('pais', 100);
            $table->string('telefone', 20)->nullable();
            $table->string('celular', 20);
            $table->foreignId('instituicao_id')->constrained('instituicoes_instituicoes');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financeiro_fornecedores');
    }
};
