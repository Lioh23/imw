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
        Schema::create('instituicoes_tiposinstituicao', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('cor', 6);
            $table->string('sigla', 1);
            $table->smallInteger('hierarquia');
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
        Schema::dropIfExists('instituicoes_tipo_instituicaos');
    }
};
