<?php

namespace App\Services\ServiceFinanceiroRelatorios;

use App\Traits\Identifiable;
use App\Traits\LivroRazaoUtils;

class LivroRazaoService
{
    public function execute($dataInicial, $dataFinal)
    {
        $instituicaoId = session()->get('session_perfil')->instituicao_id;
        return [
            'lancamentosPorConta' => LivroRazaoUtils::getLancamentosPorConta($dataInicial, $dataFinal, $instituicaoId),
            'instituicao' => $instituicaoId
        ];
    }
}
