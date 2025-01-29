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
        Schema::create('pessoas_dependentes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pessoa_id')->constrained('pessoas_pessoas');
            $table->string('nome', 100);
            $table->string('cpf', 11);
            $table->date('data_nascimento');
            $table->string('parentesco', 50);
            $table->string('sexo', 1);
            $table->boolean('declarar_em_irpf');
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
        Schema::dropIfExists('pessoas_dependentes');
    }
};
