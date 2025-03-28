<?php

namespace App\Services\EstatisticaClerigosService;


use App\Traits\Identifiable;
use App\Traits\TotalClerigosUtils;


class TotalClerigosNomeacoes
{
    use Identifiable;


    public function execute()
    {

        $regiao = Identifiable::fetchtSessionRegiao();

        return [
            'lancamentos' => TotalClerigosUtils::fetchTotalClerigosNomeacoes($regiao->id),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
            'regiao'      => $regiao
        ];
    }
}
