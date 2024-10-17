<?php

namespace App\Services\ServiceInstituicaoRegiao;

use App\Models\InstituicoesInstituicao;
use Carbon\Carbon;

class StoreRegiaoService
{
    public function execute($request)
    {
        $dataAbertura = Carbon::createFromFormat('d/m/Y', $request->input('data_abertura'))->format('Y-m-d');

        InstituicoesInstituicao::create(
            [
                'nome' => $request->input('nome'),
                'tipo_instituicao_id' => $request->input('tipo_instituicao_id'),
                'instituicao_pai_id' => $request->input('instituicao_pai_id'),
                'regiao_id' => $request->input('regiao_id'),
                'bairro' => $request->input('bairro'),
                'cep' => $request->input('cep'),
                'cidade' => $request->input('cidade'),
                'cnpj' => $request->input('cnpj'),
                'complemento' => $request->input('complemento'),
                'data_abertura' => $dataAbertura,
                'numero' => $request->input('numero'),
                'pais' => $request->input('pais'),
                'uf' => $request->input('uf'),
                'endereco' => $request->input('endereco'),
                'telefone' => $request->input('telefone'),
                'ddd' => $request->input('ddd'),
                'inss' => 0
            ]
        );
    }
}
