<?php

namespace App\Services\ServiceIgrejas;

use App\Models\InstituicoesInstituicao;
use App\Traits\LivroRazaoUtils;

class LivroRazaoService
{
    use LivroRazaoUtils;

    public function execute($dataInicial, $dataFinal, InstituicoesInstituicao $igreja): array 
    {
        return [
            'lancamentosPorConta' => LivroRazaoUtils::getLancamentosPorConta($dataInicial, $dataFinal, $igreja->id),
            'instituicao'         => $igreja
        ];
    }
}