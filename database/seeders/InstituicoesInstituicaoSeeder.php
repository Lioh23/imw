<?php

namespace Database\Seeders;

use App\Models\InstituicoesInstituicao;
use App\Models\InstituicoesTipoInstituicao;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstituicoesInstituicaoSeeder extends Seeder
{
    public function run()
    {
        $regiao = InstituicoesInstituicao::create([
            'nome' => 'Regiao Teste',
            'tipo_instituicao_id' => InstituicoesTipoInstituicao::REGIAO,
            'ativo' => true,
            'bairro' => 'Centro',
            'caw' => false,
            'cep' => '27000000',
            'cidade' => 'Rio de Janeiro',
            'cnpj' => '93876046000150',
            'data_abertura' => '2019-03-02',
            'inss' => false,
            'nome_fantasia' => 'Regiao teste',
        ]);

        $distrito = InstituicoesInstituicao::create([
            'nome' => 'Distrito Teste',
            'tipo_instituicao_id' => InstituicoesTipoInstituicao::DISTRITO,
            'instituicao_pai_id' => $regiao->id,
            'ativo' => true,
            'bairro' => 'Vila Nova',
            'caw' => false,
            'cep' => '27000000',
            'cidade' => 'Rio de Janeiro',
            'cnpj' => '85562159000152',
            'data_abertura' => '2019-01-01',
            'inss' => false,
            'nome_fantasia' => 'Distrito Teste',
        ]);
            
        InstituicoesInstituicao::create ([
            'nome' => 'Igreja Teste',
            'tipo_instituicao_id' => InstituicoesTipoInstituicao::IGREJA_LOCAL,
            'instituicao_pai_id' => $distrito->id,
            'ativo' => true,
            'bairro' => 'Vila Velha',
            'caw' => false,
            'cep' => '27000000',
            'cidade' => 'Rio de Janeiro',
            'cnpj' => '64256732000120',
            'data_abertura' => '2019-01-01',
            'inss' => false,
            'nome_fantasia' => 'Igreja Teste',
        ]);
    }
}
