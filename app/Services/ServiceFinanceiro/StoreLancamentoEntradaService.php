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
       
        $lancamentos = [
            'data_lancamento' => Carbon::now()->format('Y-m-d'),
            'valor' => $data['valor'],
            'tipo_pagante_favorecido_id' => $data['tipo_pagante_favorecido_id'],
            'pagante_favorecido' => $data['pagante_favorecido'],
            'descricao' => $data['descricao'],
            'tipo_lancamento' => FinanceiroLancamento::TP_LANCAMENTO_ENTRADA, 
            'plano_conta_id' => $data['plano_conta_id'],
            'data_movimento' => $data['data_movimento'],
            'caixa_id' => $data['caixa_id'],
            'instituicao_id' => session()->get('session_perfil')->instituicao_id
        ];
    
        FinanceiroLancamento::create($lancamentos);
    }
}