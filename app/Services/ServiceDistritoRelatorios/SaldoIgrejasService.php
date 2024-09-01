<?php

namespace App\Services\ServiceDistritoRelatorios;

use App\Traits\Identifiable;
use App\Traits\SaldoIgrejasUtils;
use Carbon\Carbon;

class SaldoIgrejasService
{
    use SaldoIgrejasUtils;
    use Identifiable;

    public function execute($dt)
    {
        if (empty($dt)) {
            $dt = Carbon::now()->format('Y/m');
        }

        $distritoId = session()->get('session_perfil')->instituicao_id;

        $lancamentos = SaldoIgrejasUtils::fetch($dt, $distritoId);

        return [
            'lancamentos' => $lancamentos
        ];
    }
}
