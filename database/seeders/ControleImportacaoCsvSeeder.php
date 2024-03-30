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
            [
                'alias' => 'congregacoes',
                'file' => 'csv/congregacoes_congregacao.csv',
                'static_method' => 'congregacoes',
                'target_table' => 'congregacoes_congregacoes',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'alias' => 'plano_contas',
                'file' => 'csv/financeiro_plano_contas.csv',
                'static_method' => 'planoContas',
                'target_table' => 'financeiro_plano_contas',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'alias' => 'pessoas_status',
                'file' => 'csv/pessoas_status.csv',
                'static_method' => 'pessoasStatus',
                'target_table' => 'pessoas_status',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'alias' => 'pessoas_pessoas',
                'file' => 'csv/pessoas_pessoa.csv',
                'static_method' => 'pessoasPessoas',
                'target_table' => 'pessoas_pessoas',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        foreach ($data as $d) { DB::table('controle_importacoes_csv')->insert($d); }
    }
}
