<?php

namespace App\Services\ServiceFinanceiro;

use App\Models\FinanceiroFornecedores;
use App\Models\FinanceiroLancamento;
use App\Models\FinanceiroSaldoConsolidadoMensal;
use App\Models\FinanceiroTipoPaganteFavorecido;
use App\Models\MembresiaMembro;
use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;

class ConsolidacaoStoreService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute($data)
    {
        // Validar os dados de entrada
        if (!isset($data['ano']) || !isset($data['mes'])) {
            throw new \InvalidArgumentException('Ano e mês são obrigatórios.');
        }

        $caixas = FinanceiroUtils::caixas();
        
        /* $todosLancamentos = []; */

        foreach ($caixas as $caixa) {
            $lancamento = [
                'data_hora' => Carbon::now()->format('Y-m-d H:i:s'),
                'total_entradas' => $caixa->totalLancamentosNaoConciliadosEntradaPorData($data['ano'], $data['mes']),
                'total_saidas' => $caixa->totalLancamentosNaoConciliadosSaidaPorData($data['ano'], $data['mes']),
                'saldo_anterior' => $caixa->totalLancamentosUltimosConciliados(),
                'saldo_final' => $caixa->saldoAtualNaoConciliadoPorData($data['ano'], $data['mes']),
                'caixa_id' => $caixa->id,
                'instituicao_id' => session()->get('session_perfil')->instituicao_id,
                'ano' => $data['ano'],
                'mes' => $data['mes'],
                'total_transf_entradas' => $caixa->totalLancamentosNaoConciliadosTransferenciaEntradaPorData($data['ano'], $data['mes']),
                'total_transf_saidas' => $caixa->totalLancamentosNaoConciliadosTransferenciaSaidaPorData($data['ano'], $data['mes'])
            ];
            
            /* $todosLancamentos[] = $lancamento; */
            // Usar o método updateOrCreate
             FinanceiroSaldoConsolidadoMensal::updateOrCreate(
                [
                    'caixa_id' => $caixa->id,
                    'ano' => $data['ano'],
                    'mes' => $data['mes']
                ],
                $lancamento
            ); 
        } 

       /*  dd($todosLancamentos); */
        $dataConciliacao = Carbon::now()->format('Y-m-d');
        
         FinanceiroLancamento::where('conciliado', 0)
        ->where('instituicao_id', session()->get('session_perfil')->instituicao_id)
        ->update([
            'conciliado' => 1,
            'data_conciliacao' => $dataConciliacao
        ]); 
    }
}
