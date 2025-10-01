<?php

namespace App\Services\ServiceFinanceiro;

use App\Traits\FinanceiroUtils;
use App\Models\FinanceiroLancamento;
use App\Models\InstituicoesInstituicao;
use Carbon\Carbon;

class IdentificaDadosCotaOrcamentariaService
{
    use FinanceiroUtils;

    public function execute($instituicao_id, $dados)
    { 
        return [
            'cotaOrcamentaria' => FinanceiroUtils::cotasOrcamentarias($instituicao_id, $dados),
        ];
    }
}
