<?php

namespace App\Services\ServiceIgrejas;
use App\Traits\IgrejasDados;
use App\Traits\Identifiable;
class CnpjIgreja
{

    public function execute(array $params = [])
    {
        $regiao = Identifiable::fetchtSessionRegiao();
        if(isset($params['igreja'])) {            
            $data['igrejas'] = IgrejasDados::fetchCnpjIgrejas($regiao->id, $params);
            $data['titulo'] = "IMW - RELATÓRIO CNPJ POR IGREJA ";
        }else{
            $data['titulo'] = "";
        }
        return $data;
    }
}