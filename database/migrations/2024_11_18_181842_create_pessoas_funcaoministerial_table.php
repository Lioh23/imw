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
        Schema::create('pessoas_funcaoministerial', function (Blueprint $table) {
            $table->id();
            $table->boolean('excluido')->default(0);
            $table->string('funcao', 50);
            $table->integer('ordem');
            $table->string('titulo', 50);
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
        Schema::dropIfExists('pessoa_funcaoministerals');
    }
};
