<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegrasDistritoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Inserir registros na tabela 'regras'
        DB::table('regras')->insert([
            // Relatórios Distritos
            ['id' => 74 ,'nome' => 'distrito-relatorio-livro-razao-geral'],
            ['id' => 75 ,'nome' => 'distrito-relatorio-orcamento'],
            ['id' => 76 ,'nome' => 'distrito-relatorio-variacao-financeira'],
            ['id' => 77 ,'nome' => 'distrito-relatorio-lancamento-das-igrejas'],
        ]);

        // Inserir registros na tabela 'perfil_regra'
        DB::table('perfil_regra')->insert([
            ['perfil_id' => 2, 'regra_id' => 74, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 2, 'regra_id' => 75, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 2, 'regra_id' => 76, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 2, 'regra_id' => 77, 'created_at' => null, 'updated_at' => null],
        ]);
    }
}
