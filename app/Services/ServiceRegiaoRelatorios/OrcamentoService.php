<?php

namespace App\Services\ServiceRegiaoRelatorios;

use App\Models\InstituicoesInstituicao;
use App\Traits\Identifiable;
use App\Traits\OrcamentoUtils;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrcamentoService
{
    use OrcamentoUtils;
    use Identifiable;

    public function execute($dtano, $distritoId)
    {
        $dtano ??= Carbon::now()->format('Y');

        $regiao = Identifiable::fetchtSessionRegiao();

        return [
            'lancamentos' => OrcamentoUtils::fetch($dtano, $distritoId, $regiao->id),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
            'instituicao' => InstituicoesInstituicao::find($distritoId)
        ];
    }
}
