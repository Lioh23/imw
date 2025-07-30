<?php

namespace App\Services\ServiceIgrejas;
use App\Traits\GetIgrejasAll;
use App\Traits\Identifiable;
class GetIgrejas
{

    public function execute(array $params = [])
    {
        $regiao = Identifiable::fetchtSessionRegiao();           
        $data = GetIgrejasAll::fetchIgrejas($regiao->id, $params);
        return $data;
    }
}