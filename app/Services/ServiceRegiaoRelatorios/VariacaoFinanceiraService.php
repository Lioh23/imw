<?php

namespace App\Services\ServiceRegiaoRelatorios;

use App\Models\InstituicoesInstituicao;
use App\Traits\Identifiable;
use App\Traits\VariacaoFinanceiraUtils;
use Carbon\Carbon;

class VariacaoFinanceiraService
{
    use VariacaoFinanceiraUtils;
    use Identifiable;

    public function execute($dataInicial, $dataFinal, $distritoId)
    {
        $dataInicial ??= Carbon::now()->format('m/Y');

        $dataFinal ??= Carbon::now()->format('m/Y');

        $regiao = Identifiable::fetchtSessionRegiao();

        return [
            'lancamentos' => VariacaoFinanceiraUtils::fetch($dataInicial, $dataFinal, $distritoId),
            'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
            'instituicao' => InstituicoesInstituicao::find($distritoId),
        ];
    }        
}
