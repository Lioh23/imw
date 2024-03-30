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
        Schema::create('notificacoes_transferencias', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('membro_id')->constrained('membresia_membros', 'id');
            $table->foreignId('regiao_origem_id')->constrained('instituicoes_instituicoes', 'id');
            $table->foreignId('distrito_origem_id')->constrained('instituicoes_instituicoes', 'id');
            $table->foreignId('igreja_origem_id')->constrained('instituicoes_instituicoes', 'id');
            $table->foreignId('regiao_destino_id')->constrained('instituicoes_instituicoes', 'id');
            $table->foreignId('distrito_destino_id')->constrained('instituicoes_instituicoes', 'id');
            $table->foreignId('igreja_destino_id')->constrained('instituicoes_instituicoes', 'id');
            $table->foreignId('user_abertura')->constrained('users', 'id');
            $table->date('dt_abertura');
            $table->foreignId('user_finalizacao')->nullable()->constrained('users', 'id');
            $table->date('dt_aceite')->nullable();
            $table->date('dt_rejeicao')->nullable();
            $table->text('motivo_rejeicao')->nullable();
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
        Schema::table('notificacoes_transferencias', function ($table) {
            $table->dropForeign('notificacoes_transferencias_membro_id_foreign');
            $table->dropForeign('notificacoes_transferencias_regiao_origem_id_foreign');
            $table->dropForeign('notificacoes_transferencias_distrito_origem_id_foreign');
            $table->dropForeign('notificacoes_transferencias_igreja_origem_id_foreign');
            $table->dropForeign('notificacoes_transferencias_regiao_destino_id_foreign');
            $table->dropForeign('notificacoes_transferencias_distrito_destino_id_foreign');
            $table->dropForeign('notificacoes_transferencias_igreja_destino_id_foreign');
            $table->dropForeign('notificacoes_transferencias_user_abertura_foreign');
            $table->dropForeign('notificacoes_transferencias_user_finalizacao_foreign');
        });
        Schema::dropIfExists('notificacao_transferencias');
    }
};
