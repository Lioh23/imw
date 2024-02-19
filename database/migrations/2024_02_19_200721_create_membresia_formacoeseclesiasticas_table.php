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
        Schema::create('membresia_formacoeseclesiasticas', function (Blueprint $table) {
            $table->id();
            $table->date('inicio')->nullable();
            $table->date('termino')->nullable();
            $table->string('observacao')->nullable();
            $table->foreignId('curso_id')->constrained('membresia_cursos');
            $table->foreignUuid('membro_id')->constrained('membresia_membros');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('membresia_formacoeseclesiasticas', function (Blueprint $table) {
            $table->dropForeign('membresia_formacoeseclesiasticas_curso_id_foreign');
            $table->dropForeign('membresia_formacoeseclesiasticas_membro_id_foreign');
        });
        Schema::dropIfExists('membresia_formacoeseclesiasticas');
    }
};
