<?php

namespace App\Services\ServiceRegiaoRelatorios;

use App\Models\InstituicoesInstituicao;
use App\Traits\EstatisticaGeneroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;

class EstatisticaGeneroService
{
    use EstatisticaGeneroUtils;
    use Identifiable;

    public function execute($dataInicial, $dataFinal, $tipo, $distritoId)
    {
        $dataInicial ??= Carbon::now()->format('Y-m-d');

        $dataFinal ??= Carbon::now()->format('Y-m-d');

        $tipo ??= 'M'; 

        $regiao = Identifiable::fetchtSessionRegiao();

        return [
            'lancamentos' => EstatisticaGeneroUtils::fetch($dataInicial, $dataFinal, $tipo, $distritoId),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
            'instituicao' => InstituicoesInstituicao::find($distritoId)
        ];
    }
}
