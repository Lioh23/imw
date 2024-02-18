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
        Schema::create('user_instituicoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('instituicao_id')->constrained('instituicoes_instituicoes');
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
        Schema::table('user_instituicoes', function (Blueprint $table) {
            $table->dropForeign('user_instituicoes_instituicao_id_foreign');
            $table->dropForeign('user_instituicoes_user_id_foreign');
        });
        Schema::dropIfExists('user_instituicoes');
    }
};
