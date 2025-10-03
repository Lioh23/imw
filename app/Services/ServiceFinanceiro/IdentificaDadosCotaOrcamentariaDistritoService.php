<?php

namespace App\Services\ServiceFinanceiro;

use App\Traits\FinanceiroUtils;
use App\Models\FinanceiroLancamento;
use App\Models\InstituicoesInstituicao;
use App\Models\Mes;
use Carbon\Carbon;

class IdentificaDadosCotaOrcamentariaDistritoService
{
    use FinanceiroUtils;

    public function execute($dados)
    { 
        return [
            'cotaOrcamentaria' => FinanceiroUtils::cotasOrcamentarias($dados),
            'meses' => (Object) Mes::get(),
        ];
    }
}