<?php

namespace App\Services\ServiceFinanceiro;

use App\Models\FinanceiroLancamento;
use Carbon\Carbon;

class StoreLancamentoEntradaService
{
    public function execute(array $data)
    {
        /* 
            TIPOS
            1 = MEMBRO
            2 = FORNECEDOR
            3 = CLERIGO
            4 = OUTROS
        */

        $chavePorTipo = [
            1 => 'membro_id',
            2 => 'fornecedores_id',
            3 => 'clerigo_id',
        ];

        $chavePadrao = 'pagante_favorecido';

        $lancamentos = [
            'data_lancamento' => Carbon::now()->format('Y-m-d'),
            'valor' => $data['valor'],
            'tipo_pagante_favorecido_id' => $data['tipo_pagante_favorecido_id'],
            'descricao' => $data['descricao'],
            'tipo_lancamento' => FinanceiroLancamento::TP_LANCAMENTO_ENTRADA,
            'plano_conta_id' => $data['plano_conta_id'],
            'data_movimento' => $data['data_movimento'],
            'caixa_id' => $data['caixa_id'],
            'instituicao_id' => session()->get('session_perfil')->instituicao_id
        ];

        // Verificar se o tipo_pagante_favorecido_id existe no mapeamento
        if (isset($chavePorTipo[$data['tipo_pagante_favorecido_id']])) {
            $lancamentos[$chavePorTipo[$data['tipo_pagante_favorecido_id']]] = $data['pagante_favorecido'];
        } else {
            $lancamentos[$chavePadrao] = $data['pagante_favorecido'];
        }

        FinanceiroLancamento::create($lancamentos);
    }
}
