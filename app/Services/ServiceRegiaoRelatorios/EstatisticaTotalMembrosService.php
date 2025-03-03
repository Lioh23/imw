<?php

namespace App\Services\ServiceRegiaoRelatorios;

use App\Models\InstituicoesInstituicao;
use App\Traits\EstatisticaGeneroUtils;
use App\Traits\EstatisticaTotalMembrosUtils;
use App\Traits\Identifiable;

class EstatisticaTotalMembrosService
{
    use EstatisticaGeneroUtils;
    use Identifiable;


    public function execute($regiaoId)
    {
        $lancamentos = EstatisticaTotalMembrosUtils::fetch($regiaoId);

        return [
            'lancamentos' => $lancamentos,
            'regioes'   => InstituicoesInstituicao::where('tipo_instituicao_id', 3)->get(),
        ];
    }
}
