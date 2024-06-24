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
        Schema::table('membresia_contatos', function (Blueprint $table) {
            $table->dropColumn('telefone_preferencial');
        });

        Schema::table('membresia_contatos', function (Blueprint $table) {
            $table->string('telefone_preferencial', 14)->nullable()->after('id');
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
            $table->dropColumn('telefone_preferencial');
        });

        Schema::table('membresia_contatos', function (Blueprint $table) {
            $table->string('telefone_preferencial', 11)->nullable()->change();
        });
    }
};
