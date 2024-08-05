<?php

namespace App\Services\ServiceIgrejas;

use App\Traits\BalanceteUtils;
use Carbon\Carbon;

class BalanceteService
{
    use BalanceteUtils;

    public function execute($dataInicial, $dataFinal, $caixaId, $igreja)
    {
        $dataInicial = empty($dataInicial) ? Carbon::now()->format('m/Y') : $dataInicial;
        $dataFinal = empty($dataFinal) ? Carbon::now()->format('m/Y') : $dataFinal;

        return [
            'instituicao'  => $igreja,
            'caixasSelect' => BalanceteUtils::handleListaCaixas($igreja->id),
            'caixas'       => BalanceteUtils::handleCaixas($dataInicial, $dataFinal, $caixaId, $igreja->id),
            'lancamentos'  => BalanceteUtils::handleLancamentos($dataInicial, $dataFinal, $caixaId, $igreja->id),
        ];
    }
}
