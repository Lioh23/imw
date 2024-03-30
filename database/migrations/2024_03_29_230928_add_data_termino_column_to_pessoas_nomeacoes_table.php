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
            $table->after('data_nomeacao', function ($table) {
                $table->date('data_termino')->nullable();
            });
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
            $table->dropColumn('data_termino');
        });
    }
};
