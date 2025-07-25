<?php

namespace App\Services\ServiceIgrejas;
use App\Traits\IgrejasDados;
use App\Traits\Identifiable;
class ContaBancariaIgreja
{

    public function execute(array $params = [])
    {
        $regiao = Identifiable::fetchtSessionRegiao();
        if(isset($params['igreja'])) {            
            $data['igrejas'] = IgrejasDados::fetchContaBancariaIgreja($regiao->id, $params);
            $data['titulo'] = "IMW - RELATÓRIO CONTA BANCÁRIA POR IGREJA ";
        }else{
            $data['titulo'] = "";
        }
        return $data;
    }
}