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
        Schema::create('pessoas_prebendas', function (Blueprint $table) {
            $table->id();
            $table->foreigniId('pessoa_id')->constrained('pessoas_pessoas');
            $table->integer('ano');
            $table->decimal('valor', 12, 2);
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
        Schema::dropIfExists('pessoas_prebendas');
    }
};
