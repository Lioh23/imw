<?php

namespace App\Services\ServiceFinanceiroRelatorios;

use App\Traits\BalanceteUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;

class BalanceteRegiaoService
{
    use BalanceteUtils, Identifiable;

    public function execute($dataInicial, $dataFinal, $caixaId, $regiao, $instituicaoId)
    {
        //$instituicaoId = session()->get('session_perfil')->instituicao_id;
        $instituicaoId = $instituicaoId;
       // dd($instituicaoId);
        if (empty($dataInicial)) {
            $dataInicial = Carbon::now()->format('m/Y');
        }

        if (empty($dataFinal)) {
            $dataFinal = Carbon::now()->format('m/Y');
        }
//2262
        return [
            'instituicao'  => $instituicaoId,
            'caixas'       => BalanceteUtils::handleCaixas($dataInicial, $dataFinal, $caixaId, $instituicaoId),
            'caixasSelect' => BalanceteUtils::handleListaCaixas($instituicaoId),
            'lancamentos'  => BalanceteUtils::handleLancamentos($dataInicial, $dataFinal, $caixaId, $instituicaoId),
            'igrejas' => BalanceteUtils::handleListaIgrejasByRegiao($regiao->id),
        ];
    }
}
