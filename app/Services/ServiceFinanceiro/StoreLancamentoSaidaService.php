<?php

namespace App\Services\ServiceFinanceiro;

use App\Models\Anexo;
use App\Models\FinanceiroFornecedores;
use App\Models\FinanceiroLancamento;
use App\Models\MembresiaMembro;
use App\Models\PessoasPessoa;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class StoreLancamentoSaidaService
{
    public function execute(array $data)
    {
        /* 
            tipo_pagante_favorecido_id 
            1 = MEMBRO
            2 = FORNECEDOR
            3 = CLERIGO
        */

        $tipoPaganteFavorecidoId = $data['tipo_pagante_favorecido_id'];
        $paganteFavorecido = $data['pagante_favorecido'];

        $lancamentos = [
            'data_lancamento' => Carbon::now()->format('Y-m-d'),
            'valor' => str_replace(',', '.', $data['valor']),
            'tipo_pagante_favorecido_id' => $tipoPaganteFavorecidoId,
            'descricao' => $data['descricao'],
            'tipo_lancamento' => FinanceiroLancamento::TP_LANCAMENTO_SAIDA,
            'plano_conta_id' => $data['plano_conta_id'],
            'data_movimento' => $data['data_movimento'],
            'caixa_id' => $data['caixa_id'],
            'instituicao_id' => session()->get('session_perfil')->instituicao_id
        ];

        $paganteFavorecidoModel = null;
        $campoId = null;

        switch ($tipoPaganteFavorecidoId) {
            case 1:
                $paganteFavorecidoModel = MembresiaMembro::find($paganteFavorecido);
                $campoId = 'membro_id';
                break;
            case 2:
                $paganteFavorecidoModel = FinanceiroFornecedores::find($paganteFavorecido);
                $campoId = 'fornecedores_id';
                break;
            case 3:
                $paganteFavorecidoModel = PessoasPessoa::find($paganteFavorecido);
                $campoId = 'clerigo_id';
                break;
            default:
                $lancamentos['pagante_favorecido'] = $paganteFavorecido;
                break;
        }

        if ($paganteFavorecidoModel) {
            $lancamentos['pagante_favorecido'] = $paganteFavorecidoModel->nome;
            $lancamentos[$campoId] = $paganteFavorecido;
        }

        $lancamento = FinanceiroLancamento::create($lancamentos);

        // Upload dos anexos
        $anexos = [];
        for ($i = 1; $i <= 3; $i++) {
            $campoAnexo = "anexo{$i}";
            $campoDescricao = "descricao_anexo{$i}";

            if (isset($data[$campoAnexo]) && $data[$campoAnexo]->isValid() && $data[$campoAnexo]->getMimeType() === 'application/pdf') {
                $fileName = Uuid::uuid4()->toString() . '.' . $data[$campoAnexo]->getClientOriginalExtension();
                $filePath = $data[$campoAnexo]->storeAs('anexos', $fileName, 'minio');

                $anexo = [
                    'nome' => $fileName,
                    'caminho' => $filePath,
                    'descricao' => $data[$campoDescricao],
                    'lancamento_id' => $lancamento->id,
                ];

                $anexos[] = $anexo;
            } elseif (isset($data[$campoAnexo]) && !$data[$campoAnexo]->isValid()) {
                // Tratar erro de arquivo inválido
                // Por exemplo, retornar uma mensagem de erro ou registrar um log
            }
        }

        // Salvar os anexos no banco de dados
        foreach ($anexos as $anexo) {
            Anexo::create($anexo);
        }
    }
}
