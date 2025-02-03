<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegrasRegiaoEstatisticaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regras')->insert([
            // Relatórios Regionais
            ['id' => 100 ,'nome' => 'regiao-menu-estatistica'],
            ['id' => 101 ,'nome' => 'regiao-estatistica-clerigo-faixa-etaria'],
            ['id' => 102 ,'nome' => 'regiao-estatistica-clerigo-recebimento-desligamento'],

        ]);

        DB::table('perfil_regra')->insert([
            //Admin Região
            ['perfil_id' => 3, 'regra_id' => 100, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 3, 'regra_id' => 101, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 3, 'regra_id' => 102, 'created_at' => null, 'updated_at' => null]
        ]);
    }
}
