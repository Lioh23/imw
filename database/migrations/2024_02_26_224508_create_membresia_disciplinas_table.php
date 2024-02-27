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
        Schema::create('membresia_disciplinas', function (Blueprint $table) {
            $table->id();
            $table->date('dt_inicio');
            $table->date('dt_termino');
            $table->foreignId('modo_disciplina_id')->constrained('membresia_situacoes');
            $table->foreignId('pastor_id')->constrained('pessoas_pessoas');
            $table->text('observacao');
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
        Schema::dropIfExists('membresia_disciplinas');
    }
};
