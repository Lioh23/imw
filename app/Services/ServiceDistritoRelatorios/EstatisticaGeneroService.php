<?php

namespace App\Services\ServiceDistritoRelatorios;

use App\Traits\EstatisticaGeneroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;

class EstatisticaGeneroService
{
    use EstatisticaGeneroUtils;
    use Identifiable;

    public function execute($dataInicial, $dataFinal, $tipo)
    {
        if (empty($dataInicial)) {
            $dataInicial = Carbon::now()->format('Y-m-d');
        }

        if (empty($dataFinal)) {
            $dataFinal = Carbon::now()->format('Y-m-d');
        }

        if (empty($tipo)) {
            $tipo = 'M';
        }

        $distritoId = session()->get('session_perfil')->instituicao_id;

        $lancamentos = EstatisticaGeneroUtils::fetch($dataInicial, $dataFinal, $tipo, $distritoId);

        return [
            'lancamentos' => $lancamentos
        ];
    }
}
