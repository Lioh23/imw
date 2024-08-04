<?php

namespace App\Services\ServiceFinanceiroRelatorios;

use App\Models\FinanceiroCaixa;
use App\Models\FinanceiroLancamento;
use App\Traits\Identifiable;
use App\Traits\MovimentoDiarioUtils;

class MovimentoDiarioService
{
    use MovimentoDiarioUtils, Identifiable;

    public function execute($dataInicial, $dataFinal, $caixaId)
    {
        $caixasFind = null;
        $instituicaoId = session()->get('session_perfil')->instituicao_id;

        if(isset($caixaId) && $caixaId !== 'all') {
            $caixasFind = FinanceiroCaixa::where('id', $caixaId)->get();
        } else {
            $caixasFind = MovimentoDiarioUtils::handleListaCaixas($instituicaoId);
        }
            
        $lancamentosPorCaixa = MovimentoDiarioUtils::handleListaLancamentosPorCaixa($caixasFind, $dataInicial, $dataFinal);
        $caixas = MovimentoDiarioUtils::handleListaCaixas($instituicaoId);

        return [
            'instituicao' => Identifiable::fetchSessionIgrejaLocal(),
            'caixas' => $caixas,
            'lancamentosPorCaixa' => $lancamentosPorCaixa,
        ];
    }
}
