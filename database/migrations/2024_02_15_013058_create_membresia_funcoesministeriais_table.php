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
        Schema::create('membresia_funcoesministeriais', function (Blueprint $table) {
            $table->id();
            $table->date('data_entrada')->nullable();
            $table->date('data_saida')->nullable();
            $table->text('observacoes')->nullable();
            $table->foreignUuid('membro_id')->constrained('membresia_membros', 'id');
            $table->foreignId('setor_id')->constrained('membresia_setores');
            $table->foreignId('tipoatuacao_id')->constrained('membresia_tiposatuacao');
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
        Schema::table('membresia_funcoesministeriais', function (Blueprint $table) {
            $table->dropForeign('membresia_funcoesministeriais_membro_id_foreign');
            $table->dropForeign('membresia_funcoesministeriais_setor_id_foreign');
            $table->dropForeign('membresia_funcoesministeriais_tipoatuacao_id_foreign');
        });
        Schema::dropIfExists('membresia_funcoesministeriais');
    }
};
