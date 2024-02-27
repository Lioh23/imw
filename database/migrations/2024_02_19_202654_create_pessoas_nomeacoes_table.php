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
        Schema::create('pessoas_nomeacoes', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_host')->nullable();
            $table->date('data_nomeacao');
            $table->foreignId('hist_distrito_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('hist_geral_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('hist_igreja_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('hist_orgao_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('hist_regiao_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('hist_secretaria_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('instituicao_id')->constrained('instituicoes_instituicoes');
            $table->foreignId('pessoa_id')->constrained('pessoas_pessoas');
            $table->foreignId('funcao_ministerial_id')->nullable()->constrained('membresia_funcoesministeriais');
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
        Schema::table('pessoas_nomeacoes', function (Blueprint $table) {
            $table->dropForeign('pessoas_nomeacoes_hist_distrito_id_foreign');
            $table->dropForeign('pessoas_nomeacoes_hist_geral_id_foreign');
            $table->dropForeign('pessoas_nomeacoes_hist_igreja_id_foreign');
            $table->dropForeign('pessoas_nomeacoes_hist_orgao_id_foreign');
            $table->dropForeign('pessoas_nomeacoes_hist_regiao_id_foreign');
            $table->dropForeign('pessoas_nomeacoes_hist_secretaria_id_foreign');
            $table->dropForeign('pessoas_nomeacoes_instituicao_id_foreign');
            $table->dropForeign('pessoas_nomeacoes_pessoa_id_foreign');
            $table->dropForeign('pessoas_nomeacoes_funcao_ministerial_id_foreign');
        });
        Schema::dropIfExists('pessoas_nomeacoes');
    }
};
