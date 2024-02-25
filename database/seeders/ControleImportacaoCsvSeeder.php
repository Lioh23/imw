<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ControleImportacaoCsvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'alias' => 'instituicoes',
                'file' => 'csv/instituicoes_instituicao.csv',
                'static_method' => 'instituicoes',
                'target_table' => 'instituicoes_instituicoes',
                'created_at' => Carbon::now(),  
                'updated_at' => Carbon::now()
            ],
        ];

        foreach ($data as $d) { DB::table('controle_importacoes_csv')->insert($d); }
    }
}
