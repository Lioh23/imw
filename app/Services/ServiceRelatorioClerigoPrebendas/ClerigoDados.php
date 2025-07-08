<?php

namespace App\Services\ServiceRelatorioClerigoPrebendas;


use App\Traits\ClerigoPrebenda;
use App\Traits\Identifiable;

class ClerigoDados
{
    use Identifiable;


    public function execute(array $params = [])
    {
        $regiao = Identifiable::fetchtSessionRegiao();
        $data =  [];
        if(isset($params['action'])) {
            $data =  [
                'clerigos'   => ClerigoPrebenda::fetchClerigoDados($regiao->id, $params),
                'distritos'  => Identifiable::fetchDistritosByRegiao($regiao->id),
                'regiao'     => $regiao,
            ];
        }
        return $data;
    }
}
