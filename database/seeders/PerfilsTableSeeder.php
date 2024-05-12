<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfilsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('perfils')->insert([
            ['nome' => 'Administrador', 'nivel' => 'I'],
            ['nome' => 'Administrador Distrito', 'nivel' => 'D'],
            ['nome' => 'Administrador Região' , 'nivel' => 'R'],
            ['nome' => 'Secretario' , 'nivel' => 'I'],
            ['nome' => 'Tesoureiro' , 'nivel' => 'I'],
            ['nome' => 'Administrador do Sistema' , 'nivel' => 'S'],
            ['nome' => 'Pastor' , 'nivel' => 'I'],
        ]);
    }
}
