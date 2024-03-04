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
        Schema::table('membresia_disciplinas', function (Blueprint $table) {
            $table->dropColumn('dt_termino');
            $table->dropColumn('observacao'); 
        });

        Schema::table('membresia_disciplinas', function (Blueprint $table) {
            $table->date('dt_termino')->after('dt_inicio')->nullable();
            
            $table->after('pastor_id', function ($table) {
                $table->text('observacao')->nullable();
                $table->foreignUuid('membro_id')->constrained('membresia_membros');
                $table->foreignId('distrito_id')->nullable()->constrained('instituicoes_instituicoes');
                $table->foreignId('igreja_id')->nullable()->constrained('instituicoes_instituicoes');
                $table->foreignId('regiao_id')->nullable()->constrained('instituicoes_instituicoes');
                $table->foreignId('congregacao_id')->nullable()->constrained('congregacoes_congregacoes');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('membresia_disciplinas', function (Blueprint $table) {
            $table->dropColumn('dt_termino');
            $table->dropColumn('observacao');
        });

        Schema::table('membresia_disciplinas', function (Blueprint $table) {
            $table->date('dt_termino');
            $table->text('observacao');

            $table->dropForeign('membresia_disciplinas_membro_id_foreign');
            $table->dropForeign('membresia_disciplinas_distrito_id_foreign');
            $table->dropForeign('membresia_disciplinas_igreja_id_foreign');
            $table->dropForeign('membresia_disciplinas_regiao_id_foreign');
            $table->dropForeign('membresia_disciplinas_congregacao_id_foreign');
            $table->dropColumn('membro_id');
            $table->dropColumn('distrito_id');
            $table->dropColumn('igreja_id');
            $table->dropColumn('regiao_id');
            $table->dropColumn('congregacao_id');
        });
    }
};
