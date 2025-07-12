<?php

namespace App\Services\ServiceIgrejas;


use App\Traits\IgrejasDados;
use App\Traits\Identifiable;

class Igrejas
{
    use Identifiable;

    public function execute(array $params = [])
    {
        $regiao = Identifiable::fetchtSessionRegiao();
        $data =  [];
        if(isset($params['action'])) {
            $data =  [
                'igrejas'   => IgrejasDados::fetchCongregacoesPorIgrejas($regiao->id, $params),
                'distritos'  => Identifiable::fetchDistritosByRegiao($regiao->id),
                'regiao'     => $regiao,
            ];
        }
        return $data;
    }
}
