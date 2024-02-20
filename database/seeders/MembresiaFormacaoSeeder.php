<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembresiaFormacaoSeeder extends Seeder
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
                'id' => 1,
                'descricao' => 'Analfabeto',
                'created_at' => '2019-03-03 17:56:10',
                'updated_at' => '2019-03-03 17:56:10',
            ],
            [
                'id' => 2,
                'descricao' => 'Ens. Fundamental Incompleto',
                'created_at' => '2019-03-03 17:56:26',
                'updated_at' => '2019-03-03 17:56:26',
            ],
            [
                'id' => 3,
                'descricao' => 'Ens. Fundamental Completo',
                'created_at' => '2019-03-03 17:56:33',
                'updated_at' => '2019-03-03 17:56:33',
            ],
            [
                'id' => 4,
                'descricao' => 'Ens. Médio Incompleto',
                'created_at' => '2019-03-03 17:56:42',
                'updated_at' => '2019-03-03 17:56:42',
            ],
            [
                'id' => 5,
                'descricao' => 'Ens. Médio Completo',
                'created_at' => '2019-03-03 17:56:49',
                'updated_at' => '2019-03-03 17:56:49',
            ],
            [
                'id' => 6,
                'descricao' => 'Ens. Superior Incompleto',
                'created_at' => '2019-03-03 17:56:55',
                'updated_at' => '2019-03-03 17:56:55',
            ],
            [
                'id' => 7,
                'descricao' => 'Ens. Superior Completo',
                'created_at' => '2019-03-03 17:57:01',
                'updated_at' => '2019-03-03 17:57:01',
            ],
            [
                'id' => 8,
                'descricao' => 'Pós-Graduação',
                'created_at' => '2019-03-03 17:57:10',
                'updated_at' => '2019-03-03 17:57:10',
            ],
            [
                'id' => 9,
                'descricao' => 'Mestrado',
                'created_at' => '2019-03-03 17:57:14',
                'updated_at' => '2019-03-03 17:57:14',
            ],
            [
                'id' => 10,
                'descricao' => 'Doutorado',
                'created_at' => '2019-03-03 17:57:21',
                'updated_at' => '2019-03-03 17:57:21',
            ],
        ];

        foreach ($data as $d) { DB::table('membresia_formacoes')->insert($d); }
    }
}
