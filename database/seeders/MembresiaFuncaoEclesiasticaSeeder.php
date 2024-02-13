<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembresiaFuncaoEclesiasticaSeeder extends Seeder
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
                'descricao' => 'Presbítero',
                'titulo' => 'Pb.',
                'ordem' => 1,
                'created_at' => '2017-12-02 18:24:57',
                'updated_at' => '2017-12-02 18:24:57',
            ],
            [
                'id' => 2,
                'descricao' => 'Diácono',
                'titulo' => 'Dc.',
                'ordem' => 2,
                'created_at' => '2017-12-02 18:25:15',
                'updated_at' => '2017-12-02 18:25:15',
            ],
            [
                'id' => 3,
                'descricao' => 'Evangelista',
                'titulo' => 'Ev.',
                'ordem' => 3,
                'created_at' => '2017-12-02 18:25:31',
                'updated_at' => '2017-12-02 18:25:31',
            ],
            [
                'id' => 4,
                'descricao' => 'Diretor(a) de Departamento',
                'titulo' => null,
                'ordem' => 4,
                'created_at' => '2017-12-02 18:26:12',
                'updated_at' => '2017-12-06 20:18:29',
            ],
            [
                'id' => 5,
                'descricao' => 'Conselheiro(a) de Departamento',
                'titulo' => null,
                'ordem' => 4,
                'created_at' => '2017-12-02 18:26:24',
                'updated_at' => '2017-12-06 20:19:48',
            ],
            [
                'id' => 6,
                'descricao' => 'Superintendente de EBD',
                'titulo' => null,
                'ordem' => 4,
                'created_at' => '2017-12-02 18:27:28',
                'updated_at' => '2017-12-06 20:19:41',
            ],
            [
                'id' => 7,
                'descricao' => 'Aspirante',
                'titulo' => 'Asp.',
                'ordem' => 1,
                'created_at' => '2017-12-02 18:28:24',
                'updated_at' => '2017-12-02 18:28:24',
            ],
            [
                'id' => 8,
                'descricao' => 'Líder de Ministério',
                'titulo' => null,
                'ordem' => 4,
                'created_at' => '2017-12-02 18:28:45',
                'updated_at' => '2017-12-06 20:18:15',
            ],
            [
                'id' => 9,
                'descricao' => 'Secretário(a) de Assembléia',
                'titulo' => null,
                'ordem' => 4,
                'created_at' => '2017-12-02 18:29:22',
                'updated_at' => '2017-12-06 20:20:26',
            ],
            [
                'id' => 10,
                'descricao' => 'Arquivista',
                'titulo' => null,
                'ordem' => 4,
                'created_at' => '2017-12-02 18:31:22',
                'updated_at' => '2017-12-06 20:30:45',
            ],
            [
                'id' => 11,
                'descricao' => 'Agente de Literatura',
                'titulo' => null,
                'ordem' => 4,
                'created_at' => '2017-12-02 18:31:37',
                'updated_at' => '2017-12-06 20:31:09',
            ],
            [
                'id' => 12,
                'descricao' => 'Noticiarista',
                'titulo' => null,
                'ordem' => 4,
                'created_at' => '2017-12-02 18:31:46',
                'updated_at' => '2017-12-06 20:31:13',
            ],
            [
                'id' => 13,
                'descricao' => 'Diaconisa',
                'titulo' => 'Dca.',
                'ordem' => 2,
                'created_at' => '2017-12-02 19:38:21',
                'updated_at' => '2017-12-02 19:38:21',
            ],
            [
                'id' => 14,
                'descricao' => 'Missionaria Eleita',
                'titulo' => 'Mis.',
                'ordem' => 1,
                'created_at' => '2017-12-02 19:39:31',
                'updated_at' => '2017-12-02 19:39:31',
            ],
            [
                'id' => 15,
                'descricao' => 'Membro',
                'titulo' => null,
                'ordem' => 9,
                'created_at' => '2019-02-08 18:34:55',
                'updated_at' => '2019-02-08 18:34:55',
            ],
        ];

        foreach($data as $d) { DB::table('membresia_funcoeseclesiasticas')->insert($d); }
    }
}
