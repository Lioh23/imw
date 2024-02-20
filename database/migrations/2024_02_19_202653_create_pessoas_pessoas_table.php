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
        Schema::create('pessoas_pessoas', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_host')->nullable();
            $table->string('tipo', 3)->nullable();
            $table->string('nome', 100);
            $table->string('status', 20)->nullable();
            $table->string('foto')->nullable();
            $table->string('identidade', 30)->nullable();
            $table->string('orgao_emissor', 50)->nullable();
            $table->date('data_emissao')->nullable();
            $table->string('cpf', 11)->nullable();
            $table->string('inss', 30)->nullable();
            $table->string('endereco', 100)->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('complemento', 30)->nullable();
            $table->string('bairro', 100)->nullable();
            $table->string('cidade', 100)->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('pais', 2)->nullable();
            $table->string('cep', 8)->nullable();
            $table->string('email')->nullable();
            $table->string('estado_civil', 1)->nullable();
            $table->date('data_nascimento')->nullable();
            $table->foreignId('situacao_id')->nullable()->constrained('pessoas_status');
            $table->string('pessoas_pessoacol', 45)->nullable();
            $table->foreignId('distrito_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('igreja_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->foreignId('regiao_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->string('sexo', 1);
            $table->integer('raca')->nullable();
            $table->string('escolaridade', 2)->nullable();
            $table->string('natural_cidade', 50)->nullable();
            $table->string('natural_uf', 2)->nullable();
            $table->string('nome_conjuge', 50)->nullable();
            $table->string('nome_mae', 50)->nullable();
            $table->string('nome_pai', 50)->nullable();
            $table->string('telefone_alternativo', 11)->nullable();
            $table->string('telefone_preferencial', 11)->nullable();
            $table->string('certidao_civil', 30)->nullable();
            $table->string('ctps', 10)->nullable();
            $table->date('ctps_emissao')->nullable();
            $table->string('habilitacao', 15)->nullable();
            $table->string('habilitacao_categoria', 2)->nullable();
            $table->string('habilitacao_emissor', 30)->nullable();
            $table->string('habilitacao_uf', 2)->nullable();
            $table->string('identidade_uf', 2)->nullable();
            $table->string('pispasep', 11)->nullable();
            $table->date('pispasep_emissao')->nullable();
            $table->string('reservista', 15)->nullable();
            $table->string('reservista_secao', 5)->nullable();
            $table->string('reservista_serie', 5)->nullable();
            $table->boolean('residencia_propria');
            $table->boolean('residencia_propria_fgts');
            $table->string('titulo_eleitor', 15)->nullable();
            $table->string('titulo_eleitor_secao', 5)->nullable();
            $table->string('titulo_eleitor_zona', 5)->nullable();
            $table->boolean('ficha_completa_ok')->nullable();
            $table->boolean('ficha_skip')->nullable();
            $table->boolean('isento_pis')->nullable();
            $table->boolean('isento_reservista')->nullable();
            $table->boolean('isento_titulo_eleitor')->nullable();
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
        Schema::table('pessoas_pessoas', function (Blueprint $table) {
            $table->dropForeign('pessoas_pessoas_situacao_id_foreign');
            $table->dropForeign('pessoas_pessoas_distrito_id_foreign');
            $table->dropForeign('pessoas_pessoas_igreja_id_foreign');
            $table->dropForeign('pessoas_pessoas_regiao_id_foreign');
        });
        Schema::dropIfExists('pessoas_pessoas');
    }
};
