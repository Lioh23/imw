<?php

namespace App\Services\EstatisticaClerigosService;


use App\Traits\Identifiable;
use App\Traits\TotalClerigosUtils;


class TotalClerigosTipoVinculo
{
    use Identifiable;


    public function execute()
    {
        $regiao = Identifiable::fetchtSessionRegiao();

        return [
            'lancamentos' => TotalClerigosUtils::fetchTotalClerigosTipoVinculo($regiao->id),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
            'regiao'      => $regiao
        ];
    }
}
