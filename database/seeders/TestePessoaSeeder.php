<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestePessoaSeeder extends Seeder
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
                'nome' => 'Clerigo Teste TI',
                'tipo' => 'CLE',
                'sexo' => 'M',
                'residencia_propria' => true,
                'residencia_propria_fgts' => true,
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ]
        ];

        foreach($data as $d) { DB::table('pessoas_pessoas')->insert($d); }
    }
}
