<?php

namespace App\Services\ServiceRelatorioClerigoPrebendas;


use App\Traits\ClerigoEsposa;
use App\Traits\Identifiable;

class ClerigoEsposas
{
    use Identifiable;


    public function execute(array $params = [])
    {
        $regiao = Identifiable::fetchtSessionRegiao();
        $data =  [];
        //if(isset($params['action'])) {
            $data =  [
                'esposas'   => ClerigoEsposa::fetchClerigoEsposa($regiao->id, $params),
                'distritos'         => Identifiable::fetchDistritosByRegiao($regiao->id),
                'regiao'            => $regiao,
                'mes'               => ''
            ];
        //}
        return $data;
    }
}
