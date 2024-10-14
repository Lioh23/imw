<?php

namespace App\Services\ServiceInstituicaoRegiao;

use App\Models\InstituicoesInstituicao;
use Carbon\Carbon;

class UpdateRegiaoDistritosService
{
    public function execute($request, $id)
    {
        $distrito = InstituicoesInstituicao::findORFail($id);
        $dataAbertura = Carbon::createFromFormat('d/m/Y', $request->input('data_abertura'))->format('Y-m-d');
        if (isset($distrito)) {
            try {
                $distrito->update(
                    [
                        'nome' => $request->input('nome'),
                        'tipo_instituicao_id' => $request->input('tipo_instituicao_id'),
                        'instituicao_pai_id' => $request->input('tipo_instituicao_id'),
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
               
            } catch (\Exception $e) {
                return response()->json(['mensagem' => 'Erro ao editar o distrito.', 'error' => $e->getMessage()], 500);
            }
        }
    }
}
