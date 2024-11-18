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
        Schema::table('pessoas_nomeacoes', function (Blueprint $table) {
            $table->dropForeign('pessoas_nomeacoes_funcao_ministerial_id_foreign');
            $table->dropColumn('funcao_ministerial_id');
        });

        Schema::table('pessoas_nomeacoes', function (Blueprint $table) {
            $table->foreignId('funcao_ministerial_id')->nullable()->after('pessoa_id')->constrained('membresia_funcoesministeriais');
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
            $table->dropForeign('pessoas_nomeacoes_funcao_ministerial_id_foreign');
            $table->dropColumn('funcao_ministerial_id');
        });

        Schema::table('pessoas_nomeacoes', function (Blueprint $table) {
            $table->foreignId('funcao_ministerial_id')->nullable()->after('pessoa_id')->constrained('membresia_funcoesministeriais');
        });
    }
};
