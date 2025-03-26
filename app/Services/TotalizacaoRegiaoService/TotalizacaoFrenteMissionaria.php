<?php

namespace App\Services\TotalizacaoRegiaoService;


use App\Traits\Identifiable;
use App\Traits\TotalizacaoRegiaoUtils;


class TotalizacaoFrenteMissionaria
{
    use Identifiable;

    public function execute($instituicao)
    {


        $regiao = Identifiable::fetchtSessionRegiao();

        return [
            'lancamentos' => TotalizacaoRegiaoUtils::fetchFrenteMissionaria($instituicao),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
            'regiao'      => $regiao
        ];
    }
}
