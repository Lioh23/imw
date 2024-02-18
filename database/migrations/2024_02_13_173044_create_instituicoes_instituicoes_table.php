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
        Schema::create('instituicoes_instituicoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->foreignId('tipo_instituicao_id')->constrained('instituicoes_tiposinstituicao');
            $table->foreignId('instituicao_pai_id')->nullable()->constrained('instituicoes_instituicoes');
            $table->integer('codigo_host')->nullable();
            $table->boolean('ativo')->default(true);
            $table->string('bairro', 100)->nullable();
            $table->boolean('caw')->default(false);
            $table->string('cep', 8)->nullable();
            $table->string('cidade', 100)->nullable();
            $table->string('cnpj', 14)->nullable();
            $table->string('complemento', 30)->nullable();
            $table->date('data_abertura')->nullable();
            $table->string('ddd', 2)->nullable();
            $table->string('email')->nullable();
            $table->string('endereco', 100)->nullable();
            $table->boolean('inss');
            $table->string('nome_fantasia', 100)->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('pais', 20)->nullable();
            $table->string('site')->nullable();
            $table->string('telefone', 9)->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('pastor', 100)->nullable();
            $table->string('tesoureiro', 100)->nullable();
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
        Schema::table('instituicoes_instituicoes', function (Blueprint $table) {
            $table->dropForeign('instituicoes_instituicoes_tipo_instituicao_id_foreign');
            $table->dropForeign('instituicoes_instituicoes_instituicao_pai_id_foreign');
        });
        Schema::dropIfExists('instituicoes_instituicoes');
    }
};
