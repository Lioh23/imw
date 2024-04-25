<?php

namespace App\Services\ServiceFinanceiroCaixas;

use App\Models\FinanceiroCaixa;
use App\Models\FinanceiroLancamento;

class DeletarFinanceiroCaixasService
{
    public function execute($id)
    {
        $hasLancamentos = FinanceiroLancamento::where('caixa_id', $id)->exists();
        
        if (!$hasLancamentos) {
            $caixa = FinanceiroCaixa::findOrFail($id);
            $caixa->delete();
        } else {
            throw new \Exception('Não é possível excluir o caixa pois existem lançamentos associados a ele.');
        }
    }
}
