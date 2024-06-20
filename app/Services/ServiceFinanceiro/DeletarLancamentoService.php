<?php

namespace App\Services\ServiceFinanceiro;

use App\Models\FinanceiroLancamento;

class DeletarLancamentoService
{

    public function execute($id)
    {
        $lancamento = FinanceiroLancamento::findOrFail($id);

        if ($lancamento->instituicao_id == session()->get('session_perfil')->instituicao_id) {
            $lancamento->forceDelete();
        } else {
            throw new \Exception('Permissão negada para excluir este lançamento.');
        }
    }
}