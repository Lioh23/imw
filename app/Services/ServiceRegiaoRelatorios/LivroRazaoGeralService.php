<?php

namespace App\Services\ServiceRegiaoRelatorios;

use App\Models\InstituicoesInstituicao;
use App\Traits\Identifiable;
use App\Traits\LivroRazaoGeralUtils;
use Carbon\Carbon;

class LivroRazaoGeralService
{
    use LivroRazaoGeralUtils;
    use Identifiable;

    public function execute($dataInicial, $dataFinal, $distritoId, $igrejaId)
    {
        $dataInicial ??= Carbon::now()->format('Y-m-d');

        $dataFinal ??= Carbon::now()->format('Y-m-d');

        $regiao = Identifiable::fetchtSessionRegiao();

        return [
            'lancamentos' => LivroRazaoGeralUtils::fetch($dataInicial, $dataFinal, $distritoId, $igrejaId),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
            'instituicao' => InstituicoesInstituicao::find($distritoId),
            'igrejas'     => Identifiable::fetchIgrejasByDistrito($distritoId)
        ];
    }
}
