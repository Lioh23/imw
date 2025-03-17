<?php

namespace App\Services\EstatisticaClerigosService;


use App\Traits\Identifiable;
use App\Traits\TotalClerigosUtils;


class TotalClerigosFaxiaEtaria
{
    use Identifiable;


    public function execute()
    {
        $regiao = Identifiable::fetchtSessionRegiao();

        return [
            'lancamentos' => TotalClerigosUtils::fetchTotalClerigosFaxiaEtaria($regiao->id),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
            'regiao'      => $regiao
        ];
    }
}
