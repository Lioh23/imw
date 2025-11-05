<?php

namespace App\Services\ServiceFinanceiroRelatorios;

use App\Traits\BalanceteUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BalanceteService
{
    use BalanceteUtils, Identifiable;

    public function execute($dataInicial, $dataFinal, $caixaId)
    {
        $instituicaoId = session()->get('session_perfil')->instituicao_id;
        if (empty($dataInicial)) {
            $dataInicial = Carbon::now()->format('m/Y');
        }

        if (empty($dataFinal)) {
            $dataFinal = Carbon::now()->format('m/Y');
        }
        $dataIni = explode('/',$dataInicial);
            $tdInicial = $dataIni[1].$dataIni[0];        
            $dataFin = explode('/',$dataFinal); 
            $tdFinal  = $dataFin[1].$dataFin[0];
            $sql = "
                SELECT  *
                    FROM financeiro_saldo_consolidado_mensal fscm
                    WHERE fscm.instituicao_id = '$instituicaoId' AND (fscm.ano * 100 + fscm.mes) between $tdInicial AND $tdFinal";
            $existeSaldoConsolidado = DB::select($sql);
        if(count($existeSaldoConsolidado)){
            return [
                'instituicao'  => $instituicaoId,
                'caixas'       => BalanceteUtils::handleCaixas($dataInicial, $dataFinal, $caixaId, $instituicaoId),
                'caixasSelect' => BalanceteUtils::handleListaCaixas($instituicaoId),
                'lancamentos'  => BalanceteUtils::handleLancamentos($dataInicial, $dataFinal, $caixaId, $instituicaoId)
            ];
        }else{
            return [
                'instituicao'  => 0,
                'caixas'       => [],
                'caixasSelect' => [],
                'lancamentos'  => []
            ];
        }
    }
}
