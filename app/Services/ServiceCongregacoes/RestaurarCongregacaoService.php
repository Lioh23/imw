<?php

namespace App\Services\ServiceCongregacoes;

use App\Models\CongregacoesCongregacao;

class RestaurarCongregacaoService
{
    public function execute($id)
    {
        $congregacao = CongregacoesCongregacao::withTrashed()->findOrFail($id);
        $congregacao->restore();
        $congregacao->update([
            'data_extincao' => null,
            'ativo'         => 1
        ]);
    }
}