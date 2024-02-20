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
        Schema::create('membresia_rolpermanente', function (Blueprint $table) {
            $table->id();
            $table->string('status', 1);
            $table->integer('numero_rol')->nullable();
            $table->integer('codigo_host')->nullable();
            $table->date('dt_recepcao');
            $table->date('dt_exclusao')->nullable();
            $table->foreignId('clerigo_id')->nullable()->constrained('pessoas_pessoas');
            $table->foreignId('distrito_id')->constrained('instituicoes_instituicoes');
            $table->foreignId('igreja_id')->constrained('instituicoes_instituicoes');
            $table->foreignUuid('membro_id')->constrained('membresia_membros');
            $table->foreignId('modo_exclusao_id')->nullable()->constrained('membresia_situacoes');
            $table->foreignId('modo_recepcao_id')->constrained('membresia_situacoes');
            $table->foreignId('regiao_id')->constrained('instituicoes_instituicoes');
            $table->foreignId('congregacao_id')->nullable()->constrained('congregacoes_congregacoes');
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
        Schema::table('membresia_rolpermanente', function (Blueprint $table) {
            $table->dropForeign('membresia_rolpermanente_clerigo_id_foreign'); 
            $table->dropForeign('membresia_rolpermanente_distrito_id_foreign'); 
            $table->dropForeign('membresia_rolpermanente_igreja_id_foreign'); 
            $table->dropForeign('membresia_rolpermanente_membro_id_foreign'); 
            $table->dropForeign('membresia_rolpermanente_modo_exclusao_id_foreign'); 
            $table->dropForeign('membresia_rolpermanente_modo_recepcao_id_foreign'); 
            $table->dropForeign('membresia_rolpermanente_regiao_id_foreign'); 
            $table->dropForeign('membresia_rolpermanente_congregacao_id_foreign'); 
        });
        Schema::dropIfExists('membresia_rolpermanente');
    }
};
