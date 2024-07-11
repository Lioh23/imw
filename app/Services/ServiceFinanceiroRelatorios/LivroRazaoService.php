<?php

namespace App\Services\ServiceFinanceiroRelatorios;

use App\Models\FinanceiroCaixa;
use App\Models\FinanceiroLancamento;
use Carbon\Carbon;

class LivroRazaoService
{
    public function execute($dataInicial, $dataFinal, $caixaId)
    {
        $caixasFind = $this->handleListaCaixas($caixaId);
        $lancamentosPorCaixa = $this->handleListaLancamentosPorCaixa($caixasFind, $dataInicial, $dataFinal);

        return [
            'caixas' => $caixasFind,
            'lancamentosPorCaixa' => $lancamentosPorCaixa,
        ];
    }

    private function handleListaCaixas($caixaId)
    {
        $query = FinanceiroCaixa::where('instituicao_id', session()->get('session_perfil')->instituicao_id)
            ->orderBy('id', 'asc');

        if ($caixaId !== 'all' && isset($caixaId)) {
            $query->where('id', $caixaId);
        }

        return $query->get();
    }

    private function handleListaLancamentosPorCaixa($caixas, $dataInicial, $dataFinal)
    {
        $lancamentosPorCaixa = [];

        foreach ($caixas as $caixa) {
            $lancamentosPorCaixa[$caixa->descricao] = $this->getLancamentosPorCaixa($caixa->id, $dataInicial, $dataFinal);
        }

        return $lancamentosPorCaixa;
    }

    private function getLancamentosPorCaixa($caixaId, $dataInicial, $dataFinal)
    {
        return FinanceiroLancamento::join('financeiro_plano_contas', 'financeiro_lancamentos.plano_conta_id', '=', 'financeiro_plano_contas.id')
            ->where('financeiro_lancamentos.caixa_id', $caixaId)
            ->whereBetween('financeiro_lancamentos.data_movimento', [$dataInicial, $dataFinal])
            ->orderBy('financeiro_plano_contas.numeracao', 'asc')
            ->orderBy('financeiro_lancamentos.data_movimento', 'asc')
            ->orderBy('financeiro_lancamentos.descricao', 'asc')
            ->get();
    }
}
