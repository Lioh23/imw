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
        Schema::create('financeiro_caixas', function (Blueprint $table) {
            $table->id();
            $table->string('descricao', 100);
            $table->foreignId('instituicao_id')->constrained('instituicoes_instituicoes');
            $table->string('tipo', 1);
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
        Schema::table('financeiro_caixas', function (Blueprint $table) {
            $table->dropForeign('financeiro_caixas_instituicao_id_foreign');
        });
        Schema::dropIfExists('financeiro_caixas');
    }
};
