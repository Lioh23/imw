<?php

namespace App\Services\ServiceRegiaoRelatorios;

use App\Models\InstituicoesInstituicao;
use App\Traits\Identifiable;
use App\Traits\MembrosMinisterioUtils;
use Carbon\Carbon;

class MembrosMinisterioService
{
    use MembrosMinisterioUtils;
    use Identifiable;

    public function execute($dataInicial, $dataFinal, $tipo, $distritoId)
    {
        $dataInicial ??= Carbon::now()->format('Y-m-d');

        $dataFinal ??= Carbon::now()->format('Y-m-d');

        $tipo ??= 'M'; 

        $regiao = Identifiable::fetchtSessionRegiao();

        return [
            'lancamentos' => MembrosMinisterioUtils::fetch($dataInicial, $dataFinal, $tipo, $distritoId),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
            'instituicao' => InstituicoesInstituicao::find($distritoId)
        ];
    }
}
