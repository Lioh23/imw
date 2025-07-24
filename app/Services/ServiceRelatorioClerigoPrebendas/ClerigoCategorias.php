<?php

namespace App\Services\ServiceRelatorioClerigoPrebendas;


use App\Traits\ClerigoPrebenda;
use App\Traits\Identifiable;

class ClerigoCategorias
{
    use Identifiable;


    public function execute(array $params = [])
    {
        $regiao = Identifiable::fetchtSessionRegiao();
        $data =  [];
        if(isset($params['action'])) {
            $data =  [
                'categorias'   => ClerigoPrebenda::fetchClerigoCategoria($regiao->id, $params),
                'distritos'    => Identifiable::fetchDistritosByRegiao($regiao->id),
                'regiao'       => $regiao,
                'mes'          => ''
            ];
        }
        return $data;
    }
}
