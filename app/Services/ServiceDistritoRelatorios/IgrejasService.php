<?php

namespace App\Services\ServiceDistritoRelatorios;


use App\Traits\IgrejasDadosDistrito;

class IgrejasService
{

    public function execute(array $params = [])
    {
        $data =  [];
        $params['distritoId'] = session()->get('session_perfil')->instituicao_id;
        if(isset($params['action'])) {
            $data =  [
                'igrejas'   => IgrejasDadosDistrito::fetchCongregacoesPorIgrejas($params),
            ];
        }
        return $data;
    }
}
