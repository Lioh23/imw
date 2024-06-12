<?php

namespace App\Services\ServiceFinanceiro;

use App\Models\FinanceiroFornecedores;
use App\Models\FinanceiroTipoPaganteFavorecido;
use App\Models\MembresiaMembro;
use App\Services\ServiceFinanceiroRelatorios\LivroCaixaService;
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
        $formattedDate = $oldCaixa instanceof Carbon ? $oldCaixa->format('m/Y') : null;

        // Capture o array retornado por LivroCaixaService
        $data = app(LivroCaixaService::class)->execute($formattedDate, 'all');
        
        // Adicione o novo item ao array
        $data['ultimoCaixa'] = $oldCaixa;

        // Retorne o array modificado
        return $data;
    }
}