<?php

namespace App\Services\ServiceFinanceiroCaixas;

use App\Models\FinanceiroCaixa;

class UpdateFinanceiroCaixasService
{
    public function execute($data, $id)
    {
        $caixa = FinanceiroCaixa::findOrFail($id);
        
        $caixa->update([
            'descricao' => $data['descricao'],
            'tipo' => $data['tipo'],
        ]);
    }
}
