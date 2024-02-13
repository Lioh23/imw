<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstituicoesTipoInstituicaoSeeder extends Seeder
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
                'nome' => 'IGREJA LOCAL',
                'cor' => '3F51B5',
                'sigla' => 'I',
                'hierarquia' => 6,
                'created_at' => '2016-09-13 18:45:40',
                'updated_at' => '2019-02-12 20:10:54',
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'nome' => 'DISTRITO',
                'cor' => '9688',
                'sigla' => 'D',
                'hierarquia' => 5,
                'created_at' => '2016-09-14 22:02:07',
                'updated_at' => '2016-10-26 03:46:44',
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'nome' => 'REGIÃO',
                'cor' => '607D8B',
                'sigla' => 'R',
                'hierarquia' => 2,
                'created_at' => '2016-09-14 22:02:39',
                'updated_at' => '2016-10-26 23:52:18',
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'nome' => 'ÓRGÃO GERAL',
                'cor' => 'FF9800',
                'sigla' => '',
                'hierarquia' => 0,
                'created_at' => '2016-09-14 22:31:35',
                'updated_at' => '2016-09-14 23:44:59',
                'deleted_at' => '2001-01-01 00:00:00',
            ],
            [
                'id' => 5,
                'nome' => 'SECRETARIA REGIONAL',
                'cor' => '795548',
                'sigla' => '',
                'hierarquia' => 0,
                'created_at' => '2016-09-14 22:36:35',
                'updated_at' => '2016-09-14 23:44:39',
                'deleted_at' => '2001-01-01 00:00:00',
            ],
            [
                'id' => 6,
                'nome' => 'IGREJA GERAL',
                'cor' => '795548',
                'sigla' => 'G',
                'hierarquia' => 1,
                'created_at' => '2016-09-14 23:06:01',
                'updated_at' => '2016-10-26 23:52:48',
                'deleted_at' => null,
            ],
            [
                'id' => 7,
                'nome' => 'SECRETARIA GERAL',
                'cor' => '\0',
                'sigla' => '',
                'hierarquia' => 0,
                'created_at' => '2016-09-14 23:35:47',
                'updated_at' => '2016-09-14 23:44:48',
                'deleted_at' => '2001-01-01 00:00:00',
            ],
            [
                'id' => 8,
                'nome' => 'ÓRGÃO GERAL',
                'cor' => '4CAF50',
                'sigla' => 'O',
                'hierarquia' => 3,
                'deleted_at' => null,
                'created_at' => '2016-09-15 00:18:33',
                'updated_at' => '2016-10-26 03:46:19',
            ],
            [
                'id' => 9,
                'nome' => 'SECRETARIA',
                'cor' => '03A9F4',
                'sigla' => 'S',
                'hierarquia' => 4,
                'deleted_at' => null,
                'created_at' => '2016-09-15 00:19:02',
                'updated_at' => '2016-11-01 16:52:54',
            ],
            [
                'id' => 10,
                'nome' => 'CONGREGAÇÃO',
                'cor' => 'FFC107',
                'sigla' => '',
                'hierarquia' => 0,
                'created_at' => '2016-09-17 12:34:21',
                'updated_at' => '2016-09-17 12:39:55',
                'deleted_at' => '2001-01-01 00:00:00',
            ],
            [
                'id' => 11,
                'nome' => 'CONTABILIDADE',
                'cor' => 'FF9800',
                'sigla' => 'C',
                'hierarquia' => 2,
                'deleted_at' => null,
                'created_at' => '2016-11-03 17:23:13',
                'updated_at' => '2016-11-04 18:54:33',
            ],
            [
                'id' => 12,
                'nome' => 'Contabilidade',
                'cor' => 'FFC107',
                'sigla' => 'C',
                'hierarquia' => 3,
                'created_at' => '2016-11-03 17:23:16',
                'updated_at' => '2016-11-03 17:23:46',
                'deleted_at' => '2001-01-01 00:00:00',
            ],
            [
                'id' => 13,
                'nome' => 'CONGREGAÇÃO',
                'cor' => '9E9E9E',
                'sigla' => 'N',
                'hierarquia' => 7,
                'created_at' => '2016-12-22 20:04:25',
                'updated_at' => '2016-12-22 20:04:25',
                'deleted_at' => null,
            ],
            [
                'id' => 14,
                'nome' => 'ESTATISTICA',
                'cor' => '4B4B4B',
                'sigla' => 'E',
                'hierarquia' => 2,
                'created_at' => '2020-10-17 21:40:51',
                'updated_at' => '2021-11-29 05:35:22',
                'deleted_at' => null,
            ],
        ];

        foreach($data as $d) { DB::table('instituicoes_tiposinstituicao')->insert($d); }
    }
}
