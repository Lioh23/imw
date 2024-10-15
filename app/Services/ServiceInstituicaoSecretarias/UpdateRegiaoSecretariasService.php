<?php

namespace App\Services\ServiceInstituicaoSecretarias;

use App\Models\InstituicoesInstituicao;
use Carbon\Carbon;

class UpdateRegiaoSecretariasService
{
    public function execute($request, $id)
    {
        $secretaria = InstituicoesInstituicao::findORFail($id);
        $dataAbertura = Carbon::createFromFormat('d/m/Y', $request->input('data_abertura'))->format('Y-m-d');
        if (isset($secretaria)) {
            try {
                $secretaria->update(
                    [
                        'nome' => $request->input('nome'),
                        'tipo_instituicao_id' => $request->input('tipo_instituicao_id'),
                        'instituicao_pai_id' => $request->input('instituicao_pai_id'),
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
                        'inss' => 0
                    ]
                );
               
            } catch (\Exception $e) {
                return response()->json(['mensagem' => 'Erro ao editar a secretaria.', 'error' => $e->getMessage()], 500);
            }
        }
    }
}
