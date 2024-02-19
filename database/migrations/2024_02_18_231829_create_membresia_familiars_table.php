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
        Schema::create('membresia_familiares', function (Blueprint $table) {
            $table->id();
            $table->string('mae_nome', 100)->nullable(); 
            $table->string('pai_nome', 100)->nullable(); 
            $table->string('conjuge_nome', 100)->nullable();
            $table->date('data_casamento')->nullable();
            $table->text('filhos')->nullable();
            $table->text('historico_familiar')->nullable();
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
        Schema::table('membresia_familiares', function (Blueprint $table) {
            $table->dropForeign('membresia_familiares_membro_id_foreign');
        });
        Schema::dropIfExists('membresia_familiares');
    }
};
