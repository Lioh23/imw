<?php

namespace App\Services\ServiceFinanceiro;

use App\Models\FinanceiroFornecedores;
use App\Models\FinanceiroTipoPaganteFavorecido;
use App\Models\MembresiaMembro;
use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;

class IdentificaDadosNovaMovimentacaoService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute($tipo = null)
    {
        return [
            'planoContas'              => FinanceiroUtils::planoContas($tipo),
            'caixas'                   => FinanceiroUtils::caixas(),
            'tiposPagantesFavorecidos' => FinanceiroTipoPaganteFavorecido::all(),
            'membros'                  => FinanceiroUtils::membros(),
            'fornecedores'             => FinanceiroUtils::fornecedores(),
            'clerigos'                 => Identifiable::fetchPastores(),
        ];
    }
}