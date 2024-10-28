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
            $table->enum('categoria', ['missionária', 'pastor', 'ministro', 'bispo'])->nullable();
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
            $table->dropColumn('categoria');
        });
    }
};
