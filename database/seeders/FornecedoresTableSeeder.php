<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FornecedoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('financeiro_fornecedores')->insert([
            [
                'cpfcnpj' => '12345678901',
                'nome' => 'Fornecedor Exemplo 1',
                'email' => 'fornecedor1@example.com',
                'site' => 'www.fornecedor1.com',
                'cep' => '12345678',
                'logradouro' => 'Rua Exemplo 1',
                'numero' => '123',
                'complemento' => 'Complemento Exemplo 1',
                'bairro' => 'Bairro Exemplo 1',
                'cidade' => 'Cidade Exemplo 1',
                'uf' => 'UF',
                'pais' => 'Brasil',
                'telefone' => '(11) 1234-5678',
                'celular' => '(11) 98765-4321',
                'instituicao_id' => 2215,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cpfcnpj' => '98765432101',
                'nome' => 'Fornecedor Exemplo 2',
                'email' => 'fornecedor2@example.com',
                'site' => 'www.fornecedor2.com',
                'cep' => '87654321',
                'logradouro' => 'Rua Exemplo 2',
                'numero' => '456',
                'complemento' => 'Complemento Exemplo 2',
                'bairro' => 'Bairro Exemplo 2',
                'cidade' => 'Cidade Exemplo 2',
                'uf' => 'UF',
                'pais' => 'Brasil',
                'telefone' => '(22) 9876-5432',
                'celular' => '(22) 1234-5678',
                'instituicao_id' => 2215,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
