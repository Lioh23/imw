<?php

namespace App\Services\ServiceFinanceiro;

use App\Traits\FinanceiroUtils;
use App\Models\Mes;

class IdentificaDadosRecursoHumanoService
{
    use FinanceiroUtils;

    public function execute($dados)
    { 
        return [
            'recursosHumanos' => FinanceiroUtils::recursosHumanos($dados),
            'meses' => (Object) Mes::get(),
        ];
    }
}
