<?php

namespace App\Services\ServiceFonecedor;

use App\Models\FinanceiroFornecedores;

class DeletarFornecedorService
{
    public function execute($id)
    {
        $fornecedor = FinanceiroFornecedores::findOrFail($id);
        $fornecedor->delete();
    }
}
