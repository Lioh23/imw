<?php

namespace App\Services\ServiceFinanceiroCaixas;

use App\Models\FinanceiroCaixa;

class DeletarFinanceiroCaixasService
{
    public function execute($id)
    {
        $caixa = FinanceiroCaixa::findOrFail($id);
        $caixa->delete();
    }
}
