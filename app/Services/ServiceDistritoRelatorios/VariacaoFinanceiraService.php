<?php

namespace App\Services\ServiceDistritoRelatorios;

use App\Traits\Identifiable;
use App\Traits\VariacaoFinanceiraUtils;
use Carbon\Carbon;

class VariacaoFinanceiraService
{
    use VariacaoFinanceiraUtils;
    use Identifiable;

    public function execute($dataInicial, $dataFinal)
    {
        if (empty($dataInicial)) {
            $dataInicial = Carbon::now()->format('m/Y');
        }

        if (empty($dataFinal)) {
            $dataFinal = Carbon::now()->format('m/Y');
        }

        $instituicaoPaiId = session()->get('session_perfil')->instituicao_id;
        
        $lancamentos = VariacaoFinanceiraUtils::fetch($dataInicial, $dataFinal, $instituicaoPaiId);

        return [
            'lancamentos' => $lancamentos
        ];
    }
}
