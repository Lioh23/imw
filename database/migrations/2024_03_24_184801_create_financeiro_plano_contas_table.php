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
        Schema::create('financeiro_plano_contas', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->smallInteger('posicao');
            $table->string('numeracao', 50);
            $table->string('tipo', 1);
            $table->foreignId('conta_pai_id')->nullable()->constrained('financeiro_plano_contas');
            $table->boolean('selecionavel')->default(true);
            $table->boolean('essencial')->default(false);
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
        Schema::table('financeiro_plano_contas', function (Blueprint $table) {
            $table->dropForeign('financeiro_plano_contas_conta_pai_id_foreign');
        });
        Schema::dropIfExists('financeiro_plano_contas');
    }
};
