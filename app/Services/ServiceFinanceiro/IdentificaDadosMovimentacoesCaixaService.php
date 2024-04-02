<?php

namespace App\Services\ServiceFinanceiro;

use App\Traits\FinanceiroUtils;

class IdentificaDadosMovimentacoesCaixaService
{
    use FinanceiroUtils;    

    public function execute()
    {
        return [
            'planoContas' => FinanceiroUtils::planoContas(),
            'caixas'      => FinanceiroUtils::caixas()
        ];
    }
}