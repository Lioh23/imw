<?php

namespace App\Services\ServiceFinanceiroRelatorios;

use App\Models\FinanceiroCaixa;
use App\Models\FinanceiroLancamento;
use App\Models\FinanceiroPlanoConta;
use Carbon\Carbon;

class LivroRazaoService
{
    public function execute($dataInicial, $dataFinal)
    {
        return [
            'lancamentosPorConta' => $this->getLancamentosPorConta($dataInicial, $dataFinal),
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


    private function getLancamentosPorConta($dataInicial, $dataFinal)
    {
        return FinanceiroPlanoConta::with('lancamentosPorIgreja.caixa')
            ->whereHas('lancamentosPorIgreja', function ($query) use ($dataInicial, $dataFinal) {
                $query->whereBetween('data_lancamento', [$dataInicial, $dataFinal]);
            })
            ->get();
    }
}
