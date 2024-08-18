<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegrasRegiaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regras')->insert([
            // Relatórios Regionais
            ['id' => 84 ,'nome' => 'regiao-relatorio-livro-razao-geral'],
            ['id' => 85 ,'nome' => 'regiao-relatorio-orcamento'],
            ['id' => 86 ,'nome' => 'regiao-relatorio-variacao-financeira'],
            ['id' => 87 ,'nome' => 'regiao-relatorio-lancamento-das-igrejas'],
            ['id' => 88 ,'nome' => 'regiao-menu-relatorio'],
            ['id' => 89 ,'nome' => 'regiao-relatorio-saldo-das-igrejas'],
            ['id' => 90 ,'nome' => 'regiao-relatorio-membros-ministerio'],
            ['id' => 91 ,'nome' => 'regiao-relatorio-quantidade-membros'],
            ['id' => 92 ,'nome' => 'regiao-relatorio-estatistica-genero'],

            // região igreja
            ['id' => 93 ,'nome' => 'regiao-gestao-igrejas'],
        ]);

        DB::table('perfil_regra')->insert([
            //Admin Região
            ['perfil_id' => 3, 'regra_id' => 84, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 3, 'regra_id' => 85, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 3, 'regra_id' => 86, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 3, 'regra_id' => 87, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 3, 'regra_id' => 88, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 3, 'regra_id' => 89, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 3, 'regra_id' => 90, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 3, 'regra_id' => 91, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 3, 'regra_id' => 92, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 3, 'regra_id' => 93, 'created_at' => null, 'updated_at' => null],
            
            //Tesoureiro região
            ['perfil_id' => 11, 'regra_id' => 84, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 11, 'regra_id' => 85, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 11, 'regra_id' => 86, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 11, 'regra_id' => 87, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 11, 'regra_id' => 88, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 11, 'regra_id' => 89, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 11, 'regra_id' => 90, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 11, 'regra_id' => 91, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 11, 'regra_id' => 92, 'created_at' => null, 'updated_at' => null],
            ['perfil_id' => 11, 'regra_id' => 93, 'created_at' => null, 'updated_at' => null],
        ]);
    }
}
