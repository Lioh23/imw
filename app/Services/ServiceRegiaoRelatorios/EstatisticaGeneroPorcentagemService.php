<?php

namespace App\Services\ServiceRegiaoRelatorios;

use App\Models\InstituicoesInstituicao;
use App\Models\MembresiaFormacao;
use App\Models\PessoasPessoa;
use App\Traits\EstatisticaEstadoCivilUtils;
use App\Traits\EstatisticaGeneroPorcentagemUtils;
use App\Traits\EstatisticaGeneroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;

class EstatisticaGeneroPorcentagemService
{
    use EstatisticaGeneroUtils;
    use Identifiable;

    public function execute($distritoId)
    {


        $regiao = Identifiable::fetchtSessionRegiao();


        return [
            'lancamentos' => EstatisticaGeneroPorcentagemUtils::fetch($distritoId, $regiao->id),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
            'instituicao' => InstituicoesInstituicao::find($distritoId),
            'regiao'      => $regiao,
        ];
    }
}
