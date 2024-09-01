<?php

namespace App\Services\ServiceRegiaoRelatorios;

use App\Models\InstituicoesInstituicao;
use App\Traits\SaldoIgrejasUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;

class SaldoIgrejasService
{
    use SaldoIgrejasUtils;
    use Identifiable;

    public function execute($dt, $distritoId)
    {
        $dt ??= Carbon::now()->format('Y/m');

        $regiao = Identifiable::fetchtSessionRegiao();
     
        return [
            'lancamentos' => SaldoIgrejasUtils::fetch($dt, $distritoId),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
            'instituicao' => InstituicoesInstituicao::find($distritoId)
        ];
    }
}
