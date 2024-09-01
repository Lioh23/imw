<?php

namespace App\Services\ServiceDistritoRelatorios;

use App\Traits\MembrosMinisterioUtils;
use Carbon\Carbon;

class MembrosMinisterioService
{
    use MembrosMinisterioUtils;

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
        
        $lancamentos = MembrosMinisterioUtils::fetch($dataInicial, $dataFinal, $tipo, $distritoId);

        return [
            'lancamentos' => $lancamentos
        ];
    }
}
