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
        Schema::table('instituicoes_instituicoes', function (Blueprint $table) {
            $table->foreignId('regiao_id')->nullable()->constrained('instituicoes_instituicoes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instituicoes_instituicoes', function (Blueprint $table) {
            $table->dropColumn('regiao_id');
        });
    }
};
