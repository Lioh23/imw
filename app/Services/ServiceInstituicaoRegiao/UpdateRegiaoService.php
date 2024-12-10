<?php

namespace App\Services\ServiceInstituicaoRegiao;

use App\Models\InstituicoesInstituicao;
use Carbon\Carbon;

class UpdateRegiaoService
{
    public function execute($request, $id)
    {
        $instituicao = InstituicoesInstituicao::findOrFail($id);
        $dataAbertura = Carbon::parse($request->input('data_abertura'))->format('Y-m-d');
        $cep = str_replace('.', '', $request->input('cep'));
        $instituicao->update(
            [
                'nome' => $request->input('nome'),
                'tipo_instituicao_id' => $request->input('tipo_instituicao_id'),
                'instituicao_pai_id' => $request->input('instituicao_pai_id'),
                'regiao_id' => $request->input('regiao_id'),
                'bairro' => $request->input('bairro'),
                'cep' => $cep,
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
