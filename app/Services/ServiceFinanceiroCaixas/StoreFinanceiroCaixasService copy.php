<?php

namespace App\Services\ServiceFinanceiroCaixas;

use App\Models\FinanceiroCaixa;

class StoreFinanceiroCaixasService
{
    public function execute($data)
    {
        FinanceiroCaixa::create([
            'descricao' => $data['descricao'],
            'instituicao_id' => session()->get('session_perfil')->instituicao_id,
            'tipo' => $data['tipo'],
        ]);
    }
}
