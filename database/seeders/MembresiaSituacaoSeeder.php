<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembresiaSituacaoSeeder extends Seeder
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
                'descricao' => 'Conforme Art11, letra a, do Estatuto e Regimento Interno da IMW', 
                'tipo' => 'R', 
                'nome' => 'Batismo',
                'created_at' => '2017-12-02 19:18:27', 
                'updated_at' => '2018-01-14 16:50:57', 
            ],
            [
                'id' => 2,
                'descricao' => 'Pessoas vindas de outras igrejas que NAO SEJA WESLEYANA, conforme Art11, letra b, do Estatuto e Reg', 
                'tipo' => 'R', 
                'nome' => 'Adesão',
                'created_at' => '2017-12-02 19:18:49', 
                'updated_at' => '2018-01-14 16:51:34', 
            ],
            [
                'id' => 3,
                'descricao' => 'Wesleyanos ou não, que foram excluídos por abandono ou disciplina) (Art11, letra d)', 
                'tipo' => 'R', 
                'nome' => 'Reconciliação',
                'created_at' => '2017-12-02 19:19:41', 
                'updated_at' => '2018-01-14 16:51:53', 
            ],
            [
                'id' => 4,
                'descricao' => 'Membros vindos de outras Igrejas Wesleyana, Art11, letra c', 
                'tipo' => 'R', 
                'nome' => 'Transferência',
                'created_at' => '2017-12-02 19:20:03', 
                'updated_at' => '2018-01-14 16:52:14', 
            ],
            [
                'id' => 5,
                'descricao' => 'Pessoas que já são membros, mas houve alguma perda do cadastro', 
                'tipo' => 'R', 
                'nome' => 'Cadastramento',
                'created_at' => '2017-12-02 19:21:30', 
                'updated_at' => '2018-01-14 16:52:33', 
            ],
            [
                'id' => 6,
                'descricao' => 'Conforme Art13, item I, do Estatuto e Regimento Interno da IMW', 
                'tipo' => 'E', 
                'nome' => 'Pedido',
                'created_at' => '2017-12-02 19:25:28', 
                'updated_at' => '2018-01-14 16:52:58', 
            ],
            [
                'id' => 7,
                'descricao' => 'Ausência maior que 6 meses sem justificativa, conforme Art13, item II e III do Est Reg Interno', 
                'tipo' => 'E', 
                'nome' => 'Abandono',
                'created_at' => '2017-12-02 19:26:24', 
                'updated_at' => '2018-01-14 16:53:42', 
            ],
            [
                'id' => 8,
                'descricao' => 'Exclusão Sumária por Justa Causa (Art13, item V e VI)', 
                'tipo' => 'E', 
                'nome' => 'Exclusão',
                'created_at' => '2017-12-02 19:27:17', 
                'updated_at' => '2018-01-13 18:24:24', 
            ],
            [
                'id' => 9,
                'descricao' => 'Falecimento (Art13, item IV)', 
                'tipo' => 'E', 
                'nome' => 'Falecimento',
                'created_at' => '2017-12-02 19:28:03', 
                'updated_at' => '2018-01-13 18:24:34', 
            ],
            [
                'id' => 10,
                'descricao' => 'Transferência Para Outra Igreja Wesleyana, conforme Art12, letra b, item 2, do EstRegInterno IMW', 
                'tipo' => 'E', 
                'nome' => 'Transferência',
                'created_at' => '2017-12-02 19:28:43', 
                'updated_at' => '2018-01-14 16:54:22', 
            ],
            [
                'id' => 11,
                'created_at' => '2018-01-24 21:45:46', 
                'updated_at' => '2018-01-24 21:45:46', 
                'descricao' => 'Membro excluido por estar em duplicidade no Rol', 
                'tipo' => 'E', 
                'nome' => 'Duplicidade',
            ],
            [
                'id' => 12,
                'created_at' => '2018-01-26 20:46:26', 
                'updated_at' => '2018-01-26 20:46:26', 
                'descricao' => 'Transferência entre sede e congregaçoes', 
                'tipo' => 'T', 
                'nome' => 'Transferência Interna',
            ],
            [
                'id' => 13,
                'created_at' => '2018-01-26 22:15:30', 
                'updated_at' => '2018-01-26 22:18:39', 
                'descricao' => 'Afastamento das atividades e da comunhão (Art14 a 16, 106 a 108)', 
                'tipo' => 'D', 
                'nome' => 'Disciplina',
            ]
        ];
        
        foreach($data as $d) { DB::table('membresia_situacoes')->insert($d); }
    }
}
