<?php

namespace App\Services\ServiceFinanceiro;

use App\Traits\FinanceiroUtils;

class IdentificaDadosNovaMovimentacaoService
{
    use FinanceiroUtils;

    public function execute($tipo = null)
    {
        return [
            'planoContas' => FinanceiroUtils::planoContas($tipo),
            'caixas'      => FinanceiroUtils::caixas()
        ];
    }
}