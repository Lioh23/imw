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
        Schema::create('congregacoes_congregacoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->foreignId('instituicao_id')->constrained('instituicoes_instituicoes');
            $table->boolean('ativo')->default(true);
            $table->string('bairro', 100)->nullable();
            $table->string('cep', 8)->nullable();
            $table->string('cidade', 100)->nullable();
            $table->integer('codigo_host')->nullable();
            $table->integer('codigo_host_igreja')->nullable();
            $table->string('complemento', 30)->nullable();
            $table->date('data_abertura')->nullable();
            $table->string('ddd', 2)->nullable();
            $table->string('email')->nullable();
            $table->string('endereco', 100)->nullable();
            $table->string('host_dirigente', 100)->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('pais', 30)->nullable();
            $table->string('site')->nullable();
            $table->string('telefone', 9)->nullable();
            $table->string('uf', 2)->nullable();
            $table->date('data_extincao')->nullable();
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
        Schema::dropIfExists('congregacoes_congregacaos');
    }
};
