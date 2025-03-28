<?php

namespace App\Services\TotalizacaoRegiaoService;


use App\Traits\Identifiable;
use App\Traits\TotalizacaoRegiaoUtils;


class TotalizacaoIgrejasDistritosService
{
    use Identifiable;

    public function execute()
    {


        $regiao = Identifiable::fetchtSessionRegiao();

        return [
            'lancamentos' => TotalizacaoRegiaoUtils::fetchTotalIgrejasPorDistrito($regiao->id),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
            'regiao'      => $regiao
        ];
    }
}
