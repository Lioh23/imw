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
        Schema::table('pessoas_funcaoministerial', function (Blueprint $table) {
            $table->decimal('qtd_prebendas', 5, 2)->after('titulo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pessoas_funcaoministerial', function (Blueprint $table) {
            $table->dropColumn('qtd_prebendas');
        });
    }
};
