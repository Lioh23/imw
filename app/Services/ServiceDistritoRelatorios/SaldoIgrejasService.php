<?php

namespace App\Services\ServiceDistritoRelatorios;

use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SaldoIgrejasService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute($dt)
    {
        if (empty($dt)) {
            $dt = Carbon::now()->format('Y/m');
        }

        $lancamentos = $this->handleLancamentos($dt);

        return [
            'lancamentos' => $lancamentos
        ];
    }

    private function handleLancamentos($dt)
    {
      
    }
}
