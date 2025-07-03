<?php

namespace App\Services\ServiceRelatorioClerigoPrebendas;


use App\Traits\ClerigoPrebenda;
use App\Traits\Identifiable;
use App\Traits\TotalClerigosUtils;

class ClerigoAniversariantes
{
    use Identifiable;


    public function execute(array $params = [])
    {
        $regiao = Identifiable::fetchtSessionRegiao();
        return [
            'aniversariantes' => ClerigoPrebenda::fetchClerigoAniversarinates($regiao->id, $params),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
            'regiao'      => $regiao
        ];
    }
}
