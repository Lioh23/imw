<?php

namespace App\Services\ServiceRelatorioClerigoPrebendas;


use App\Traits\ClerigoPrebenda;
use App\Traits\Identifiable;

class ClerigoStatus
{
    use Identifiable;


    public function execute(array $params = [])
    {
        $regiao = Identifiable::fetchtSessionRegiao();
        $data = [];
        if(isset($params['action'])) {
            $data =  [
                'clerigos_status'   => ClerigoPrebenda::fetchClerigoStatus($regiao->id, $params),
                'distritos'         => Identifiable::fetchDistritosByRegiao($regiao->id),
                'regiao'            => $regiao,
                'mes'               => ''
            ];
        }
        $data['status'] = Identifiable::fetchPessoaStatus();
        return $data;
    }
}
