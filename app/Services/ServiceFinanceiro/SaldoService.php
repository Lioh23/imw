<?php

namespace App\Services\ServiceFinanceiro;

use App\Services\ServiceFinanceiroRelatorios\SaldoCaixaService;
use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;

class SaldoService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute()
    {
        $oldCaixa = FinanceiroUtils::ultimoCaixaConciliado();
        
        // Clone a instância de Carbon para preservar $oldCaixa
       $formattedDate = $oldCaixa instanceof Carbon ? $oldCaixa->copy()->addMonth()->format('m/Y') : null;

       $data = app(SaldoCaixaService::class)->execute($formattedDate, 'all');
       
       // Adicione o novo item ao array
       $data['ultimoCaixa'] = $oldCaixa;

       // Retorne o array modificado
       return $data;
       
       /*  return [
            'caixas' => FinanceiroUtils::caixas(),
            'ultimoCaixa' => FinanceiroUtils::ultimoCaixaConciliado()
        ]; */
    }
}