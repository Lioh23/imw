<?php

namespace App\Services\TotalizacaoRegiaoService;


use App\Traits\Identifiable;
use App\Traits\TotalizacaoRegiaoUtils;
use Carbon\Carbon;

class DezIgrejasMaisReceberamMembrosService
{
    use Identifiable;


    public function execute($dataFinal, $dataInicial)
    {

        $dataInicial ??= Carbon::now()->format('Y-m-d');
        $dataFinal ??= Carbon::now()->format('Y-m-d');
        $regiao = Identifiable::fetchtSessionRegiao();

        return [
            'lancamentos' => TotalizacaoRegiaoUtils::fetchDezIgrejaCresceramMembros($dataFinal, $dataInicial),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
            'regiao'      => $regiao
        ];
    }
}
