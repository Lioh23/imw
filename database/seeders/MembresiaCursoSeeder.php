<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembresiaCursoSeeder extends Seeder
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
                'created_at' => '2017-12-27 21:40:27',
                'updated_at' => '2018-01-13 18:21:28',
                'nome' => 'Novos Convertidos',
                'descricao' => 'Curso para novos convertidos',
            ],
            [
                'id' => 2,
                'created_at' => '2017-12-27 21:40:38',
                'updated_at' => '2018-01-13 18:21:16',
                'nome' => 'Noivos',
                'descricao' => 'Curso voltado para noivos que vão se casar',
            ],
            [
                'id' => 3,
                'created_at' => '2017-12-27 21:40:47',
                'updated_at' => '2018-01-13 18:20:50',
                'nome' => 'Pais',
                'descricao' => 'Curso voltado para novos pais',
            ],
            [
                'id' => 4,
                'created_at' => '2018-01-13 18:20:12',
                'updated_at' => '2018-01-13 18:20:12',
                'nome' => 'Homem ao Máximo',
                'descricao' => 'Curso voltado para homens',
            ],
            [
                'id' => 5,
                'created_at' => '2018-01-13 18:20:25',
                'updated_at' => '2018-01-13 18:20:25',
                'nome' => 'Mulher Única',
                'descricao' => 'Curso voltado para mulheres',
            ],
            [
                'id' => 6,
                'created_at' => '2018-01-13 18:22:13',
                'updated_at' => '2018-01-13 18:22:13',
                'nome' => 'Liderança',
                'descricao' => 'Curso de Liderança Local',
            ],
        ];

        foreach($data as $d) { DB::table('membresia_cursos')->insert($d); }
    }
}
