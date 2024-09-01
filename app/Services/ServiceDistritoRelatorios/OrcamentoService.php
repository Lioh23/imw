<?php

namespace App\Services\ServiceDistritoRelatorios;

use App\Traits\Identifiable;
use App\Traits\OrcamentoUtils;
use Carbon\Carbon;

class OrcamentoService
{
    use OrcamentoUtils;
    use Identifiable;

    public function execute($dtano)
    {
        if (empty($dtano)) {
            $dtano = Carbon::now()->format('Y');
        }

        $distritoId = session()->get('session_perfil')->instituicao_id; 

        $lancamentos = OrcamentoUtils::fetch($dtano, $distritoId);

        return [
            'lancamentos' => $lancamentos
        ];
    }
}
