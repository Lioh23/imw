<?php

namespace App\Traits;

use App\Models\FinanceiroSaldoConsolidadoMensal;
use DB;

trait MovimentoBancario
{
    public static function getMovimentosBancarios($dataInicial, $dataFinal, $instituicaoId = null)
    {
        // return FinanceiroSaldoConsolidadoMensal::select('financeiro_caixas.instituicao_id','financeiro_caixas.descricao')
        //     ->selectRaw('SUM(total_entradas) as total_entradas')
        //     ->selectRaw('SUM(total_saidas) as total_saidas')
        //     ->selectRaw('SUM(saldo_anterior) as saldo_anterior')
        //     ->selectRaw('SUM(saldo_final) as saldo_final')
        //     ->Join('financeiro_caixas','financeiro_caixas.id', 'financeiro_saldo_consolidado_mensal.caixa_id')
        //     ->whereBetween('data_hora', [$dataInicial, $dataFinal])
        //     ->where(['financeiro_caixas.tipo' => 'B', 'financeiro_caixas.instituicao_id' => $instituicaoId])
        //     ->groupBy('financeiro_caixas.instituicao_id', 'financeiro_caixas.descricao')->get();


        $sql = "SELECT fl.data_movimento  AS data ,fc.descricao as caixa, fpc.nome , fl.descricao, 
        if(fl.tipo_lancamento  = 'E',fl.valor,0) as entrada, 
        if(fl.tipo_lancamento = 'S',fl.valor,0) as saida
        from financeiro_lancamentos fl, financeiro_caixas fc, financeiro_plano_contas fpc 
        where fl.caixa_id = fc.id 
        and fl.plano_conta_id = fpc.id
        and fc.tipo = 'B'
        and fl.data_movimento between '$dataInicial' and '$dataFinal'
        and fl.instituicao_id = $instituicaoId
        order by data, caixa, descricao";

        try {
            return collect(DB::select($sql));
        } catch (\Exception $e) {
            throw $e;
        }

       
    }
}
