<?php

namespace App\Services\ServiceRegiaoRelatorios;

use App\Models\InstituicoesInstituicao;
use App\Models\MembresiaFormacao;
use App\Models\PessoasPessoa;
use App\Traits\EstatisticaEstadoCivilUtils;
use App\Traits\EstatisticaGeneroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;

class EstatisticaEstadoCivilService
{
    use EstatisticaGeneroUtils;
    use Identifiable;

    public function execute($distritoId, $estadoCivil)
    {


        $regiao = Identifiable::fetchtSessionRegiao();


        return [
            'lancamentos' => EstatisticaEstadoCivilUtils::fetch($distritoId, $estadoCivil, $regiao->id),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
            'instituicao' => InstituicoesInstituicao::find($distritoId),
            'regiao'      => $regiao,
        ];
    }
}
