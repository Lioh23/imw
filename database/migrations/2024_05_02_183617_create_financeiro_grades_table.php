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
        Schema::create('financeiro_grades', function (Blueprint $table) {
            $table->id();
            $table->integer('ano');
            $table->decimal('jan', 12, 2)->nullable();
            $table->decimal('fev', 12, 2)->nullable();
            $table->decimal('mar', 12, 2)->nullable();
            $table->decimal('abr', 12, 2)->nullable();
            $table->decimal('mai', 12, 2)->nullable();
            $table->decimal('jun', 12, 2)->nullable();
            $table->decimal('jul', 12, 2)->nullable();
            $table->decimal('ago', 12, 2)->nullable();
            $table->decimal('set', 12, 2)->nullable();
            $table->decimal('out', 12, 2)->nullable();
            $table->decimal('nov', 12, 2)->nullable();
            $table->decimal('dez', 12, 2)->nullable();
            $table->decimal('o13', 12, 2)->nullable();
            $table->foreignId('distrito_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('igreja_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignUuid('membro_id')->nullable()->constrained('membresia_membros');
            $table->foreignId('regiao_id')->nullable()->constrained('instituicoes_instituicoes');
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
        
        Schema::table('financeiro_grades', function (Blueprint $table) {
            $table->dropForeign('financeiro_grades_distrito_id_foreign');
            $table->dropForeign('financeiro_grades_membro_id_foreign');
            $table->dropForeign('financeiro_grades_regiao_id_foreign');
            $table->dropForeign('financeiro_grades_regiao_id_foreign');
        });
        Schema::dropIfExists('financeiro_grades');
    }
};
