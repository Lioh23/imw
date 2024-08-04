<?php

namespace App\Services\ServiceIgrejas;

use App\Models\InstituicoesInstituicao;
use App\Models\InstituicoesTipoInstituicao;
use App\Traits\BalanceteUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;

class BalanceteService
{
    use BalanceteUtils, Identifiable;

    public function execute($dataInicial, $dataFinal, $caixaId, $instituicaoId = null)
    {
        $distritoId = Identifiable::fetchtSessionDistrito()->id;
        $dataInicial = empty($dataInicial) ? Carbon::now()->format('m/Y') : $dataInicial;
        $dataFinal = empty($dataFinal) ? Carbon::now()->format('m/Y') : $dataFinal;

        return [
            'igrejas'      => $this->fetchIgrejasByDistrito($distritoId),
            'instituicao'  => $instituicaoId ? InstituicoesInstituicao::find($instituicaoId) : null,
            'caixasSelect' => $instituicaoId ? BalanceteUtils::handleListaCaixas($instituicaoId) : [],
            'caixas'       => $instituicaoId ? BalanceteUtils::handleCaixas($dataInicial, $dataFinal, $caixaId, $instituicaoId) : [],
            'lancamentos'  => $instituicaoId ? BalanceteUtils::handleLancamentos($dataInicial, $dataFinal, $caixaId, $instituicaoId) : [],
        ];
    }

    private function fetchIgrejasByDistrito($distritoId)
    {
        return InstituicoesInstituicao::where('instituicao_pai_id', $distritoId)
            ->where('tipo_instituicao_id', InstituicoesTipoInstituicao::IGREJA_LOCAL)
            ->get();
    }
}
