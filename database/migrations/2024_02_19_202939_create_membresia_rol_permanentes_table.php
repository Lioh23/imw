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
            $table->('clerigo_id',)
            $table->('distrito_id',)
            $table->('igreja_id',)
            $table->('membro_id',)
            $table->('modo_exclusao_id',)
            $table->('modo_recepcao_id',)
            $table->('regiao_id',)
            $table->('congregacao_id')
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
        Schema::dropIfExists('membresia_rolpermanente');
    }
};
