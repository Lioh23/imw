<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regras')->insert([
         //Admin
         ['nome' => 'admin-index'],
         ['nome' => 'admin-cadastrar'],
         ['nome' => 'admin-atualizar'],
         ['nome' => 'admin-editar'],
         ['nome' => 'admin-excluir'],
         ['nome' => 'admin-pesquisar'],
        ]);
    }
}
