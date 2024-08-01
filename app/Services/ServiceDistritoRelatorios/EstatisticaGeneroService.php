<?php

namespace App\Services\ServiceDistritoRelatorios;

use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EstatisticaGeneroService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute($dtano)
    {
        if (empty($dtano)) {
            $dtano = Carbon::now()->format('Y');
        }

        $lancamentos = $this->handleLancamentos($dtano);

        return [
            'lancamentos' => $lancamentos
        ];
    }

    private function handleLancamentos($ano)
    {
        $instituicaoPaiId = session()->get('session_perfil')->instituicao_id; 

        $result = "";

        return $result;
    }
}
