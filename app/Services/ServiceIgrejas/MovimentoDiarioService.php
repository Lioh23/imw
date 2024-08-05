<?php

namespace App\Services\ServiceIgrejas;

use App\Models\FinanceiroCaixa;
use App\Traits\MovimentoDiarioUtils;

class MovimentoDiarioService
{
    use MovimentoDiarioUtils;

    public function execute($dataInicial, $dataFinal, $caixaId, $igreja)
    {
        $caixasFind = (isset($caixaId) && $caixaId !== 'all')
            ? FinanceiroCaixa::where('id', $caixaId)->get()
            : MovimentoDiarioUtils::handleListaCaixas($igreja->id);
            
        return [
            'instituicao'         => $igreja,
            'caixas'              => MovimentoDiarioUtils::handleListaCaixas($igreja->id),  
            'lancamentosPorCaixa' => MovimentoDiarioUtils::handleListaLancamentosPorCaixa($caixasFind, $dataInicial, $dataFinal),
        ];
    }
}
