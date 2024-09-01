<?php

namespace App\Services\ServiceRegiaoRelatorios;

use App\Traits\Identifiable;
use App\Traits\QuantidadeMembrosUtils;
use Carbon\Carbon;

class QuantidadeMembrosService
{
    use QuantidadeMembrosUtils;
    use Identifiable;

    public function execute($dataInicial, $dataFinal, $tipo, $distritoId)
    {
        $dataInicial ??= Carbon::now()->format('Y-m-d');

        $dataFinal ??= Carbon::now()->format('Y-m-d');

        $tipo ??= 'M'; 

        $regiao = Identifiable::fetchtSessionRegiao();

        return [
            'lancamentos' => QuantidadeMembrosUtils::fetch($dataInicial, $dataFinal, $tipo, $distritoId),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id)
        ];
    }
}
