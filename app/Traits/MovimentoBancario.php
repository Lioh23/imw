<?php

namespace App\Traits;

use App\Models\FinanceiroSaldoConsolidadoMensal;

trait MovimentoBancario
{
    public static function getMovimentosBancarios($dataInicial, $dataFinal, $instituicaoId = null)
    {
        return FinanceiroSaldoConsolidadoMensal::select('financeiro_caixas.instituicao_id','financeiro_caixas.descricao')
            ->selectRaw('SUM(total_entradas) as total_entradas')
            ->selectRaw('SUM(total_saidas) as total_saidas')
            ->selectRaw('SUM(saldo_anterior) as saldo_anterior')
            ->selectRaw('SUM(saldo_final) as saldo_final')
            ->Join('financeiro_caixas','financeiro_caixas.id', 'financeiro_saldo_consolidado_mensal.caixa_id')
            ->whereBetween('data_hora', [$dataInicial, $dataFinal])
            ->where(['financeiro_caixas.tipo' => 'B', 'financeiro_caixas.instituicao_id' => $instituicaoId])
            ->groupBy('financeiro_caixas.instituicao_id', 'financeiro_caixas.descricao')->get();
    }
}
