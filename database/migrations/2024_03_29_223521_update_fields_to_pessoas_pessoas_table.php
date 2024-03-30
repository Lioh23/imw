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
        Schema::table('pessoas_pessoas', function (Blueprint $table) {
            $table->dropColumn('raca');
            $table->dropColumn('reservista_secao');
            $table->dropColumn('reservista_serie');
        });
        Schema::table('pessoas_pessoas', function (Blueprint $table) {
            $table->after('sexo', function ($table) {
                $table->string('raca', 1)->nullable();
            });
            $table->after('reservista', function ($table) {
                $table->string('reservista_secao', 15)->nullable();
                $table->string('reservista_serie', 15)->nullable();
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
        Schema::table('pessoas_pessoas', function (Blueprint $table) {
            $table->dropColumn('raca');
            $table->dropColumn('reservista_secao');
            $table->dropColumn('reservista_serie');
        });
        Schema::table('pessoas_pessoas', function (Blueprint $table) {
            $table->after('sexo', function ($table) {
                $table->integer('raca')->nullable();
            });
            $table->after('reservista', function ($table) {
                $table->string('reservista_secao', 5)->nullable();
                $table->string('reservista_serie', 5)->nullable();
            });
        });
    }
};
