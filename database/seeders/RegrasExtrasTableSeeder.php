<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegrasExtrasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regras')->insert([
            //Menus
            ['nome' => 'menu-relatorios-secretaria'],
            ['nome' => 'menu-relatorios-financeiro'],

            //Financeiro
            ['nome' => 'financeiro-relatorio-movimento-diario'],
            ['nome' => 'financeiro-relatorio-livrorazao'],
            ['nome' => 'financeiro-relatorio-livrocaixa'],
            ['nome' => 'financeiro-relatorio-livrograde'],
            ['nome' => 'financeiro-relatorio-balancete'],
            
        ]);
    }
}
