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
            ['nome' => 'visitantes-index'],
            ['nome' => 'visitantes-cadastrar'],
            ['nome' => 'visitantes-atualizar'],
            ['nome' => 'visitantes-editar'],
            ['nome' => 'visitantes-excluir'],
            ['nome' => 'visitantes-pesquisar'],
            ['nome' => 'visitantes-tornarcongregado'],

            //Congregados
            ['nome' => 'congregados-index'],
            ['nome' => 'congregados-cadastrar'],
            ['nome' => 'congregados-atualizar'],
            ['nome' => 'congregados-editar'],
            ['nome' => 'congregados-excluir'],
            ['nome' => 'congregados-pesquisar'],

             //Membros
             ['nome' => 'membros-index'],
             ['nome' => 'membros-cadastrar'],
             ['nome' => 'membros-atualizar'],
             ['nome' => 'membros-editar'],
             ['nome' => 'membros-excluir'],
             ['nome' => 'membros-pesquisar'],
             ['nome' => 'membros-recebernovo'],
             ['nome' => 'membros-reintegrar'],
             ['nome' => 'membros-transferenciainterna'],
             ['nome' => 'membros-exclusaotransferencia'],
             ['nome' => 'membros-disciplinar'],

             //Relatórios
             ['nome' => 'relmembresia-index'],
             ['nome' => 'relrolatual-index'],
             ['nome' => 'relrolpermanente-index'],
             ['nome' => 'relrolexcluidos-index'],
             ['nome' => 'relcongregados-index'],
             ['nome' => 'relvisitantes-index'],
             ['nome' => 'relaniversariantes-index'],
             
             //Fornecedores
             ['nome' => 'fornecedores-index'],
             ['nome' => 'fornecedores-cadastrar'],

             //Financeiro
             ['nome' => 'financeiro-movimentocaixa-index'],
             ['nome' => 'financeiro-consolidarcaixa'],
             ['nome' => 'financeiro-planoconta'],
             ['nome' => 'financeiro-caixas'],
           
        ]);
    }
}
