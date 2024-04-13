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
        Schema::create('financeiro_lancamentos', function (Blueprint $table) {
            $table->id();
            $table->date('data_lancamento');

            //Campos Novos *Vinicius
            $table->foreignId('tipo_pagante_favorecido_id')->nullable()->constrained('financeiro_tipos_pagantes_favorecidos');
            $table->foreignUuid('membro_id')->nullable()->constrained('membresia_membros', 'id');
            $table->foreignId('clerigo_id')->nullable()->constrained('pessoas_pessoas');
            $table->foreignId('fornecedores_id')->nullable()->constrained('financeiro_fornecedores');
            //FIm dos Campos Novos

            $table->decimal('valor', 12, 2);
            $table->string('pagante_favorecido', 100)->nullable();
            $table->text('descricao')->nullable();
            $table->string('tipo_lancamento', 1);
            $table->boolean('conciliado')->default(false);
            $table->date('data_vencimento')->nullable();
            $table->foreignId('plano_conta_id')->constrained('financeiro_plano_contas');
            $table->date('data_conciliacao')->nullable();
            $table->date('data_movimento')->nullable();
            $table->foreignId('caixa_id')->constrained('financeiro_caixas');
            $table->foreignId('lancamento_pai_id')->nullable()->constrained('financeiro_lancamentos');
            $table->boolean('estornado')->default(false);
            $table->foreignId('instituicao_destino_origem_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('hist_distrito_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('hist_geral_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('hist_igreja_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('hist_orgao_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('hist_regiao_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('hist_secretaria_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('instituicao_id')->nullable()->constrained('instituicoes_instituicoes');
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
        Schema::table('financeiro_lancamentos', function($table) {
            $table->dropForeign('financeiro_lancamentos_membro_id_foreign');
            $table->dropForeign('financeiro_lancamentos_tipo_pagante_favorecido_id_foreign');
            $table->dropForeign('financeiro_lancamentos_fornecedores_id_foreign');
            $table->dropForeign('financeiro_lancamentos_clerigo_id_foreign');
            $table->dropForeign('financeiro_lancamentos_plano_conta_id_foreign');
            $table->dropForeign('financeiro_lancamentos_constrained_foreign');
            $table->dropForeign('financeiro_lancamentos_caixa_id_foreign');
            $table->dropForeign('financeiro_lancamentos_instituicao_destino_origem_id_foreign');
            $table->dropForeign('financeiro_lancamentos_hist_distrito_id_foreign');
            $table->dropForeign('financeiro_lancamentos_hist_geral_id_foreign');
            $table->dropForeign('financeiro_lancamentos_hist_igreja_id_foreign');
            $table->dropForeign('financeiro_lancamentos_hist_orgao_id_foreign');
            $table->dropForeign('financeiro_lancamentos_hist_regiao_id_foreign');
            $table->dropForeign('financeiro_lancamentos_hist_secretaria_id_foreign');
            $table->dropForeign('financeiro_lancamentos_instituicao_id_foreign');
        });
        Schema::dropIfExists('financeiro_lancamentos');
    }
};
