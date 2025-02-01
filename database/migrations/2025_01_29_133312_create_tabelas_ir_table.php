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
        Schema::create('tabelas_ir', function (Blueprint $table) {
            $table->id();
            $table->integer('ano');
            $table->integer('faixa');
            $table->decimal('deducao_faixa', 12, 2);
            $table->decimal('valor_min', 12, 2);
            $table->decimal('valor_max', 12, 2)->nullable();
            $table->decimal('aliquota', 5, 2);
            $table->decimal('deducao', 12, 2);
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
        Schema::dropIfExists('tabelas_ir');
    }
};
