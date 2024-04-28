<?php

namespace App\Services\ServiceFinanceiroRelatorios;

use App\Models\FinanceiroCaixa;
use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;

class LivroCaixaService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute($dt, $caixaId)
    {

        if(isset($caixaId) && $caixaId !== 'all') {
            $caixasFind = FinanceiroCaixa::where('id', $caixaId)->get();
        } else {
            $caixasFind = FinanceiroUtils::caixas();
        }
  
        return [
            'caixas' => $caixasFind,
            'caixasSelect' => FinanceiroUtils::caixas(),
            'ultimoCaixa' => FinanceiroUtils::ultimoCaixaConciliado($dt)
        ];
    }
}
