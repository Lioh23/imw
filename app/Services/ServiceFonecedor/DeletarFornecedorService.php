<?php

namespace App\Services\ServiceFornecedor;

use App\Models\FinanceiroCaixa;
use App\Models\FinanceiroFornecedores;

class DeletarFornecedorService
{
    public function execute($id)
    {
        $fornecedor = FinanceiroFornecedores::findOrFail($id);
        $fornecedor->delete();
    }
}
