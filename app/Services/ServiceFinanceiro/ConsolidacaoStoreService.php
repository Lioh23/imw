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
        
        foreach ($caixas as $caixa) {
            $lancamento = [
                'data_hora' => Carbon::now()->format('Y-m-d H:i:s'),
                'total_entradas' => $caixa->totalLancamentosNaoConciliadosEntrada(),
                'total_saidas' => $caixa->totalLancamentosNaoConciliadosSaida(),
                'saldo_anterior' => $caixa->totalLancamentosUltimosConciliados(),
                'saldo_final' => $caixa->saldoAtualNaoConciliado(),
                'caixa_id' => $caixa->id,
                'instituicao_id' => session()->get('session_perfil')->instituicao_id,
                'ano' => $data['ano'],
                'mes' => $data['mes'],
                'total_transf_entradas' => $caixa->totalLancamentosNaoConciliadosTransferenciaEntrada(),
                'total_transf_saidas' => $caixa->totalLancamentosNaoConciliadosTransferenciaSaida()
            ];
            
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

        $dataConciliacao = Carbon::now()->format('Y-m-d');
        
        FinanceiroLancamento::where('conciliado', 0)
        ->where('instituicao_id', session()->get('session_perfil')->instituicao_id)
        ->update([
            'conciliado' => 1,
            'data_conciliacao' => $dataConciliacao
        ]);
    }
}
