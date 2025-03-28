<?php

namespace App\Services\EstatisticaClerigosService;

use App\Traits\Identifiable;
use App\Traits\TicketMedioUtils;
use Illuminate\Support\Facades\DB;

class TotalTicketMedio
{
    use Identifiable;


    public function execute($anoinicio, $anofinal)
    {
        $regiao = Identifiable::fetchtSessionRegiao();

        return [
            'lancamentos' => TicketMedioUtils::execute($anoinicio, $anofinal),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
            'regiao'      => $regiao
        ];
    }
}
