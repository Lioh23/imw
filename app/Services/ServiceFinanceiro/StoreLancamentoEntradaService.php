<?php

namespace App\Services\ServiceFinanceiro;

use App\Models\FinanceiroLancamento;
use Carbon\Carbon;

class StoreLancamentoEntradaService
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
            'tipo_lancamento' => FinanceiroLancamento::TP_LANCAMENTO_ENTRADA, 
            'plano_conta_id' => $data['plano_conta_id'],
            'data_movimento' => $data['data_movimento'],
            'caixa_id' => $data['caixa_id'],
            'instituicao_id' => session()->get('session_perfil')->instituicao_id
        ];
        
        if ($tipoPaganteFavorecidoId == 1) {
            $lancamentos['membro_id'] = $paganteFavorecido;
        } elseif ($tipoPaganteFavorecidoId == 2) {
            $lancamentos['fornecedores_id'] = $paganteFavorecido;
        } elseif ($tipoPaganteFavorecidoId == 3) {
            $lancamentos['clerigo_id'] = $paganteFavorecido;
        } else {
            $lancamentos['pagante_favorecido'] = $paganteFavorecido;
        }

        FinanceiroLancamento::create($lancamentos);
    }
}