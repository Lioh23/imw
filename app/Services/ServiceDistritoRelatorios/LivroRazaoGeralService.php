<?php

namespace App\Services\ServiceDistritoRelatorios;

use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LivroRazaoGeralService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute($dataInicial, $dataFinal)
    {

        if (empty($dataInicial)) {
            $dataInicial = Carbon::now()->format('m/Y');
        }

        if (empty($dataFinal)) {
            $dataFinal = Carbon::now()->format('m/Y');
        }

        $lancamentos = $this->handleLancamentos($dataInicial, $dataFinal);

        return [
            'lancamentos' => $lancamentos
        ];
    }

    private function handleLancamentos($dataInicial, $dataFinal)
    {
        
    }

}
