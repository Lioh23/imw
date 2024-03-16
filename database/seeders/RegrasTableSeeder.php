<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegrasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regras')->insert([
            //Visitantes
            ['nome' => 'Visitantes - Listar'],
            ['nome' => 'Visitantes - Cadastrar'],
            ['nome' => 'Visitantes - Atualizar'],
            ['nome' => 'Visitantes - Editar'],
            ['nome' => 'Visitantes - Excluir'],
            ['nome' => 'Visitantes - Pesquisar'],
            ['nome' => 'Visitantes - Tornar Congregado'],

            //Congregados
            ['nome' => 'Congregados - Listar'],
            ['nome' => 'Congregados - Cadastrar'],
            ['nome' => 'Congregados - Atualizar'],
            ['nome' => 'Congregados - Editar'],
            ['nome' => 'Congregados - Excluir'],
            ['nome' => 'Congregados - Pesquisar'],

             //Membros
             ['nome' => 'Membros - Listar'],
             ['nome' => 'Membros - Cadastrar'],
             ['nome' => 'Membros - Atualizar'],
             ['nome' => 'Membros - Editar'],
             ['nome' => 'Membros - Excluir'],
             ['nome' => 'Membros - Pesquisar'],
        ]);
    }
}
