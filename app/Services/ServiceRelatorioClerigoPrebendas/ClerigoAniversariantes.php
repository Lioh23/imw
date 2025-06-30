<?php

namespace App\Services\ServiceRelatorioClerigoPrebendas;


use App\Traits\ClerigoPrebenda;
use App\Traits\Identifiable;
use App\Traits\TotalClerigosUtils;


class ClerigoAniversariantes
{
    use Identifiable;


    public function execute($visao)
    {
        $regiao = Identifiable::fetchtSessionRegiao();
        return [
            'lancamentos' => ClerigoPrebenda::fetchClerigoAniversarinates($regiao->id),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
            'regiao'      => $regiao
        ];
    }
}
