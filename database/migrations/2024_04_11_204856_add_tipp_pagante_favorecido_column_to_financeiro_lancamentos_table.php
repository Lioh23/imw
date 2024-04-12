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
        Schema::table('financeiro_lancamentos', function (Blueprint $table) {
            $table->after('valor', function ($table) {
                $table->foreignId('tipo_pagante_favorecido_id')->nullable()->constrained('financeiro_tipos_pagantes_favorecidos');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financeiro_lancamentos', function (Blueprint $table) {
            $table->dropForeign('financeiro_lancamentos_tipo_pagante_favorecido_id_foreign');
            $table->dropColumn('tipo_pagante_favorecido_id');
        });
    }
};
