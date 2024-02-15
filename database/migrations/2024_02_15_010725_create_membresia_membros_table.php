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
            $table->uuid();
            $table->string('status', 1);
            $table->string('nome', 100);
            $table->string('sexo', 1);
            $table->date('data_nascimento');
            $table->string('estado_civil', 1);
            $table->string('nacionalidade', 2);
            $table->string('naturalidade', 50);
            $table->string('uf', 2);
            $table->text('historico');
            $table->string('cpf');
            $table->foreignId('distrito_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('igreja_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('regiao_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('escolaridade_id')->nullable()->constrained('membresia_formacoes');
            $table->string('profissao')->nullable();
            $table->string('documento', 30);
            $table->string('documento_complemento', 50);
            $table->string('tipo_documento', 3);
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
        Schema::dropIfExists('membresia_membros');
    }
};
