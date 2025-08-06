<?php

namespace App\Traits;

use App\Models\FinanceiroSaldoConsolidadoMensal;

trait MovimentoBancario
{
    public static function getMovimentosBancarios($dataInicial, $dataFinal, $instituicaoId = null)
    {
        return FinanceiroSaldoConsolidadoMensal::Join('financeiro_caixas','financeiro_caixas.id', 'financeiro_saldo_consolidado_mensal.caixa_id')
            ->whereBetween('data_hora', [$dataInicial, $dataFinal])
            ->where(['financeiro_caixas.tipo' => 'B', 'financeiro_caixas.instituicao_id' => $instituicaoId])->get();
    }
}
