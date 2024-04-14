<?php

namespace App\Services\ServiceFinanceiro;

use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;

class SaldoService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute()
    {
        return [
            'caixas' => FinanceiroUtils::caixas(),
            'ultimoCaixa' => FinanceiroUtils::ultimoCaixaConciliado()
        ];
    }
}