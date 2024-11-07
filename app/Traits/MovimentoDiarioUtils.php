<?php

namespace App\Traits;

use App\Models\FinanceiroCaixa;
use App\Models\FinanceiroLancamento;

trait MovimentoDiarioUtils
{
    public static function handleListaCaixas($instituicaoId)
    {
        return FinanceiroCaixa::where('instituicao_id', $instituicaoId)
            ->orderBy('id', 'asc')
            ->get();
    }

    public static function handleListaLancamentosPorCaixa($caixas, $dataInicial, $dataFinal)
    {
        $lancamentosPorCaixa = [];

        foreach ($caixas as $caixa) {
            $lancamentosPorCaixa[$caixa->descricao] = static::getLancamentosPorCaixa($caixa->id, $dataInicial, $dataFinal);
        }

        return $lancamentosPorCaixa;
    }

    public static function getLancamentosPorCaixa($caixaId, $dataInicial, $dataFinal)
    {
        return FinanceiroLancamento::join('financeiro_plano_contas', 'financeiro_lancamentos.plano_conta_id', '=', 'financeiro_plano_contas.id')
            ->where('financeiro_lancamentos.caixa_id', $caixaId)
            ->whereBetween('financeiro_lancamentos.data_movimento', [$dataInicial, $dataFinal])
            ->orderBy('financeiro_lancamentos.data_movimento', 'asc')
            ->orderBy('financeiro_plano_contas.numeracao', 'asc')
            ->get();
    }
}