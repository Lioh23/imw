<?php

namespace App\Services\ServiceIgrejas;
use App\Traits\IgrejasDados;
use App\Traits\Identifiable;
class ContatoIgreja
{

    public function execute(array $params = [])
    {
        $regiao = Identifiable::fetchtSessionRegiao();
        if(isset($params['igreja'])) {            
            $data['igrejas'] = IgrejasDados::fetchContatoIgrejas($regiao->id, $params);
            $data['titulo'] = "IMW - RELATÓRIO CONTATO POR IGREJA ";
        }else{
            $data['titulo'] = "";
        }
        return $data;
    }
}