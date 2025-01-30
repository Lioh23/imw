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
        Schema::create('deducoes_ir', function (Blueprint $table) {
            $table->id();
            $table->integer('ano');
            $table->string('tipo', 50);
            $table->decimal('valor', 10, 2);
            $table->boolean('simplificado')->default(false);
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
        Schema::dropIfExists('deducoes_ir');
    }
};
