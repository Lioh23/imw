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
        Schema::create('financeiro_saldo_consolidado_mensal', function (Blueprint $table) {
            $table->id();
            $table->timestamp('data_hora')->nullable();
            $table->decimal('total_entradas', 12, 2);
            $table->decimal('total_saidas', 12, 2);
            $table->decimal('saldo_anterior', 12, 2);
            $table->decimal('saldo_final', 12, 2);
            $table->boolean('estorno')->default(false);
            $table->boolean('auditado')->default(false);
            $table->foreignId('caixa_id')->constrained('financeiro_caixas');
            $table->foreignId('instituicao_id')->constrained('instituicoes_instituicoes');
            $table->smallInteger('ano');
            $table->smallInteger('mes');
            $table->decimal('total_transf_entradas', 12, 2);
            $table->decimal('total_transf_saidas', 12, 2);
            $table->timestamp('aux_data_hora')->nullable();
            $table->decimal('aux_saldo_anterior', 12, 2)->nullable();
            $table->decimal('aux_saldo_final', 12, 2)->nullable();
            $table->decimal('aux_total_entradas', 12, 2)->nullable();
            $table->decimal('aux_total_saidas', 12, 2)->nullable();
            $table->decimal('aux_total_transf_entradas', 12, 2)->nullable();
            $table->decimal('aux_total_transf_saidas', 12, 2)->nullable();
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
        Schema::table('financeiro_saldo_consolidado_mensal', function (Blueprint $table) {
            $table->dropForeign('financeiro_saldo_consolidado_mensal_caixa_id_foreign');
            $table->dropForeign('financeiro_saldo_consolidado_mensal_instituicao_id_foreign');
        });
        Schema::dropIfExists('financeiro_saldo_consolidado_mensal');
    }
};
