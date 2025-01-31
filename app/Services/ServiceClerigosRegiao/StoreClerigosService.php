<?php

namespace App\Services\ServiceClerigosRegiao;

use App\Models\PessoaNomeacao;
use App\Models\PessoasPessoa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StoreClerigosService
{
    public function execute($request)
    {
        PessoasPessoa::create([
            'nome' => $request['nome'],
            'identidade' => $request['identidade'],
            'orgao_emissor' => $request['orgao_emissor'],
            'data_emissao' => $request['data_emissao'],
            'cpf' => $request['cpf'],
            'endereco' => $request['endereco'],
            'numero' => $request['numero'],
            'regiao_id' =>   $data['regiao_id'] = 23,
            'complemento' => $request['complemento'],
            'bairro' => $request['bairro'],
            'cidade' => $request['cidade'],
            'uf' => $request['uf'],
            'pais' => $request['pais'],
            'cep' => $request['cep'],
            'residencia_propria' => $request['residencia_propria'],
            'residencia_propria_fgts' => $request['residencia_propria_fgts'],
            'email' => $request['email'],
            'estado_civil' => $request['estado_civil'],
            'sexo' => $request['sexo'],
            'nome_mae' => $request['nome_mae'],
            'nome_pai' => $request['nome_pai'],
            'data_nascimento' => $request['data_nascimento'],
            'telefone_preferencial' => $request['telefone_preferencial'],
            'telefone_alternativo' => $request['telefone_alternativo'],
            'habilitacao' => $request->input('habilitacao'),
            'habilitacao_categoria' => $request->input('habilitacao_categoria'),
            'habilitacao_emissor' => $request->input('habilitacao_emissor'),
            'habilitacao_uf' => $request->input('habilitacao_uf', ''),
            'ctps' => $request->input('ctps', ''),
            'ctps_emissao' => $request->input('ctps_emissao', ''),
            'titulo_eleitor' => $request['titulo_eleitor'],
            'titulo_eleitor_secao' => $request['titulo_eleitor_secao'],
            'titulo_eleitor_zona' => $request['titulo_eleitor_zona'],
            'formacao_id' => $request['formacao_id'],
            'categoria' => $request['categoria'],
        ]);
    }
}
