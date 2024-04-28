<?php

namespace App\Services\ServiceFinanceiroRelatorios;

use App\Models\FinanceiroCaixa;
use App\Models\FinanceiroLancamento;

class MovimentoDiarioService
{
    public function execute($dataInicial, $dataFinal, $caixaId)
    {
        $caixasFind = null;
    
        if(isset($caixaId) && $caixaId !== 'all') {
            $caixasFind = FinanceiroCaixa::where('id', $caixaId)->get();
        } else {
            $caixasFind = $this->handleListaCaixas();
        }
            
        $lancamentosPorCaixa = $this->handleListaLancamentosPorCaixa($caixasFind, $dataInicial, $dataFinal);
        $caixas = $this->handleListaCaixas();

        return [
            'caixas' => $caixas,
            'lancamentosPorCaixa' => $lancamentosPorCaixa,
        ];
    }

    private function handleListaCaixas()
    {
        return FinanceiroCaixa::where('instituicao_id', session()->get('session_perfil')->instituicao_id)
            ->orderBy('id', 'asc')
            ->get();
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
            ->orderBy('financeiro_lancamentos.data_movimento', 'asc')
            ->orderBy('financeiro_plano_contas.nome', 'asc')
            ->get();
    }
}
