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
        Schema::create('membresia_contatos', function (Blueprint $table) {
            $table->id();
            $table->string('telefone_preferencial', 11)->nullable();
            $table->string('telefone_alternativo', 11)->nullable();
            $table->string('telefone_whatsapp', 11)->nullable();
            $table->string('email_preferencial')->nullable();
            $table->string('email_alternativo')->nullable();
            $table->string('cep', 8)->nullable();
            $table->string('endereco', 100)->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('complemento', 100)->nullable();
            $table->string('bairro', 100)->nullable();
            $table->string('cidade', 100)->nullable();
            $table->string('estado', 2)->nullable();
            $table->text('observacoes')->nullable();
            $table->foreignUuid('membro_id')->constrained('membresia_membros');
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
        Schema::table('membresia_contatos', function (Blueprint $table) {
            $table->dropForeign('membresia_contatos_membro_id_foreign');
        });
        Schema::dropIfExists('membresia_contatos');
    }
};
