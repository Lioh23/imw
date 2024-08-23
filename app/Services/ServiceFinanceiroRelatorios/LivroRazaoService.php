<?php

namespace App\Services\ServiceFinanceiroRelatorios;

use App\Traits\Identifiable;
use App\Traits\LivroRazaoUtils;

class LivroRazaoService
{
    public function execute($dataInicial, $dataFinal)
    {
        return [
            'lancamentosPorConta' => LivroRazaoUtils::getLancamentosPorConta($dataInicial, $dataFinal),
            'instituicao' => Identifiable::fetchSessionIgrejaLocal()
        ];
    }
}
