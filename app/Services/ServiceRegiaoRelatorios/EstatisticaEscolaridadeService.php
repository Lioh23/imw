<?php

namespace App\Services\ServiceRegiaoRelatorios;

use App\Models\InstituicoesInstituicao;
use App\Models\MembresiaFormacao;
use App\Models\PessoasPessoa;
use App\Traits\EstatisticaEscolaridadeUtils;
use App\Traits\EstatisticaGeneroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;

class EstatisticaEscolaridadeService
{
    use EstatisticaGeneroUtils;
    use Identifiable;

    public function execute($distritoId)
    {


        $regiao = Identifiable::fetchtSessionRegiao();
        $escolaridades = MembresiaFormacao::all();


        return [
            'lancamentos' => EstatisticaEscolaridadeUtils::fetch($distritoId, $regiao->id),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
            'instituicao' => InstituicoesInstituicao::find($distritoId),
            'regiao'      => $regiao,
            'escolaridades' => $escolaridades
        ];
    }
}
