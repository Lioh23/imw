<?php

namespace App\Services\ServiceFinanceiroRelatorios;

use App\Models\FinanceiroCaixa;
use App\Models\FinanceiroLancamento;

class LivroCaixaService
{
    public function execute($dt, $caixaId)
    {
        /* $caixasFind = null;
    
        if(isset($caixaId) && $caixaId !== 'all') {
            $caixasFind = FinanceiroCaixa::where('id', $caixaId)->get();
        } else {
            $caixasFind = $this->handleListaCaixas();
        } */
            
        $caixas = $this->handleListaCaixas();

        return [
            'caixas' => $caixas
        ];
    }

    private function handleListaCaixas()
    {
        return FinanceiroCaixa::where('instituicao_id', session()->get('session_perfil')->instituicao_id)
            ->orderBy('id', 'asc')
            ->get();
    }
}
