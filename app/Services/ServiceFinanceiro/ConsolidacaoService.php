<?php

namespace App\Services\ServiceFinanceiro;

use App\Models\FinanceiroFornecedores;
use App\Models\FinanceiroTipoPaganteFavorecido;
use App\Models\MembresiaMembro;
use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;

class ConsolidacaoService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute()
    {
        return [
            'caixas' => FinanceiroUtils::caixas(),
            'ultimoCaixa' => FinanceiroUtils::ultimoCaixaConciliado(),
            'lancamentosPorConta' => FinanceiroUtils::lancamentosPorContas()
        ];
    }
}