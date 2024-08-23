<?php

namespace App\Traits;

use App\Models\FinanceiroLancamento;
use App\Models\FinanceiroPlanoConta;

trait LivroRazaoUtils
{
    public static function getLancamentosPorConta($dataInicial, $dataFinal, $instituicaoId = null)
    {
        return FinanceiroPlanoConta::with('lancamentos.caixa')
            ->whereHas('lancamentos', fn ($q) => $q->whereInstituicao($instituicaoId)->whereBetween('data_lancamento', [$dataInicial, $dataFinal]))
            ->get()
            ->map(function ($planoConta) use ($dataInicial, $dataFinal, $instituicaoId) {
                $lancamentos = $planoConta->lancamentos()
                    ->whereInstituicao($instituicaoId)
                    ->whereBetween('data_lancamento', [$dataInicial, $dataFinal])
                    ->get();

                $totalEntradas = $lancamentos->where('tipo_lancamento', FinanceiroLancamento::TP_LANCAMENTO_ENTRADA)->sum('valor');
                $totalSaidas = $lancamentos->where('tipo_lancamento', FinanceiroLancamento::TP_LANCAMENTO_SAIDA)->sum('valor');
                $total = $totalEntradas - abs($totalSaidas);

                return (object) [
                    'id' 			=> $planoConta->id,
                    'numeracao' 	=> $planoConta->numeracao,
                    'nome' 			=> $planoConta->nome,
                    'totalEntradas' => $totalEntradas,
                    'totalSaidas'   => $totalSaidas,
                    'total' 	    => $total,
                    'lancamentos'   => $lancamentos
                ];
            });
    }
}
