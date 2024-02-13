<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembresiaTipoAtuacaoSeeder extends Seeder
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
                'descricao' => 'Líder', 
                'ordem' => 2,
                'created_at' => '2017-12-02 19:15:30', 
                'updated_at' => '2017-12-06 20:33:47', 
            ],
            [
                'id' => 2,
                'descricao' => 'Vice-Líder', 
                'ordem' => 3,
                'created_at' => '2017-12-02 19:15:44', 
                'updated_at' => '2017-12-06 20:33:59', 
            ],
            [
                'id' => 3,
                'descricao' => 'Tesoureiro(a)', 
                'ordem' => 3,
                'created_at' => '2017-12-02 19:15:54', 
                'updated_at' => '2017-12-06 20:34:53', 
            ],
            [
                'id' => 4,
                'descricao' => 'Secretário(a)', 
                'ordem' => 3,
                'created_at' => '2017-12-02 19:16:04', 
                'updated_at' => '2017-12-06 20:35:07', 
            ],
            [
                'id' => 5,
                'descricao' => 'Auxiliar de liderança', 
                'ordem' => 4,
                'created_at' => '2017-12-02 19:16:25', 
                'updated_at' => '2017-12-06 20:35:18', 
            ],
            [
                'id' => 6,
                'descricao' => 'Membro (vogal ou componente)', 
                'ordem' => 8,
                'created_at' => '2017-12-02 19:17:15', 
                'updated_at' => '2017-12-02 19:17:15', 
            ],
            [
                'id' => 7,
                'descricao' => 'Conselheiro(a)', 
                'ordem' => 1,
                'created_at' => '2017-12-06 20:19:06', 
                'updated_at' => '2017-12-06 20:19:06', 
            ],
            [
                'id' => 8,
                'descricao' => 'Superintendente', 
                'ordem' => 1,
                'created_at' => '2017-12-06 20:19:06', 
                'updated_at' => '2017-12-06 20:19:30', 
            ],
            [
                'id' => 9,
                'descricao' => 'Diretor(a)', 
                'ordem' => 1,
                'created_at' => '2017-12-06 20:32:07', 
                'updated_at' => '2017-12-06 20:33:38', 
            ],
        ];

        foreach($data as $d) { DB::table('membresia_tiposatuacao')->insert($d); }
    }
}
