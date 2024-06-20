<?php

namespace App\Services\ServiceFinanceiro;

use App\Models\FinanceiroFornecedores;
use App\Models\FinanceiroLancamento;
use App\Models\MembresiaMembro;
use App\Models\PessoasPessoa;
use Carbon\Carbon;

class UpdateLancamentoEntradaService
{
    public function execute(array $data, $id)
    {
        $lancamento = FinanceiroLancamento::findOrFail($id);

        /* 
            tipo_pagante_favorecido_id 
            1 = MEMBRO
            2 = FORNECEDOR
            3 = CLERIGO
        */
        $tipoPaganteFavorecidoId = $data['tipo_pagante_favorecido_id'];
        $paganteFavorecido = $data['pagante_favorecido'] ?? null;
        $lancamento->data_lancamento = Carbon::now()->format('Y-m-d');
        $lancamento->valor = str_replace(',', '.', $data['valor']);
        $lancamento->descricao = $data['descricao'];
        $lancamento->tipo_lancamento = FinanceiroLancamento::TP_LANCAMENTO_ENTRADA;
        $lancamento->plano_conta_id = $data['plano_conta_id'];
        $lancamento->data_movimento = $data['data_movimento'];
        $lancamento->caixa_id = $data['caixa_id'];
        $lancamento->instituicao_id = session()->get('session_perfil')->instituicao_id;

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
                $lancamento->pagante_favorecido = $paganteFavorecido;
                break;
        }

        if (isset($paganteFavorecidoModel)) {
            $lancamento->pagante_favorecido = $paganteFavorecidoModel->nome;
            if ($paganteFavorecido !== null) {
                $lancamento->$campoId = $paganteFavorecido;
            }
        }

        $lancamento->save();
    }
}

