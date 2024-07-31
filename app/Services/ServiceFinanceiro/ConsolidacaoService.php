<?php

namespace App\Services\ServiceFinanceiro;
use App\Services\ServiceFinanceiroRelatorios\SaldoCaixaService;
use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;

class ConsolidacaoService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute()
    {
        $oldCaixa = FinanceiroUtils::ultimoCaixaConciliado();
        
        dd($oldCaixa);
         // Clone a instância de Carbon para preservar $oldCaixa
        $formattedDate = $oldCaixa instanceof Carbon ? $oldCaixa->copy()->addMonthsNoOverflow(1)->format('d/m/Y') : null;

        // Capture o array retornado por SaldoCaixaService
        $data = app(SaldoCaixaService::class)->execute($formattedDate, 'all');
        
        // Adicione o novo item ao array
        $data['ultimoCaixa'] = $oldCaixa;

        // Retorne o array modificado
        return $data;
    }
}