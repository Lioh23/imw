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
        Schema::create('membresia_membros', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status', 1);
            $table->string('nome', 100);
            $table->string('sexo', 1);
            $table->date('data_nascimento')->nullable();
            $table->string('estado_civil', 1)->nullable();
            $table->string('nacionalidade', 2)->nullable();
            $table->string('naturalidade', 50)->nullable();
            $table->string('uf', 2)->nullable();
            $table->text('historico')->nullable();
            $table->string('cpf')->nullable()->unique();
            $table->foreignId('distrito_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('igreja_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('regiao_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('escolaridade_id')->nullable()->constrained('membresia_formacoes');
            $table->string('profissao')->nullable();
            $table->string('documento', 30)->nullable();
            $table->string('documento_complemento', 50)->nullable();
            $table->string('tipo_documento', 3)->nullable();
            $table->string('foto')->nullable();
            $table->foreignId('funcao_eclesiastica_id')->nullable()->constrained('membresia_funcoeseclesiasticas');
            $table->integer('rol_atual')->nullable();
            $table->integer('igreja_host')->nullable();
            $table->date('data_conversao')->nullable();
            $table->date('data_batismo')->nullable();
            $table->date('data_batismo_espirito')->nullable();
            $table->string('vinculo', 1);
            $table->integer('congregacao_host')->nullable();
            $table->integer('codigo_host')->nullable();
            $table->foreignId('congregacao_id')->nullable()->constrained('congregacoes_congregacoes');
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
        Schema::table('membresia_membros', function (Blueprint $table) {
            $table->dropForeign('membresia_membros_distrito_id_foreign');
            $table->dropForeign('membresia_membros_igreja_id_foreign');
            $table->dropForeign('membresia_membros_regiao_id_foreign');
            $table->dropForeign('membresia_membros_escolaridade_id_foreign');
            $table->dropForeign('membresia_membros_funcao_eclesiastica_id_foreign');
            $table->dropForeign('membresia_membros_congregacao_id_foreign');
        });
        Schema::dropIfExists('membresia_membros');
    }
};
