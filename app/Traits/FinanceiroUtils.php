<?php

namespace App\Traits;

use App\Models\FinanceiroCaixa;
use App\Models\FinanceiroFornecedores;
use App\Models\FinanceiroLancamento;
use App\Models\FinanceiroPlanoConta;
use App\Models\MembresiaMembro;
use Carbon\Carbon;

trait FinanceiroUtils
{
    public static function planoContas($tipo = null)
    {
        return FinanceiroPlanoConta::orderBy('numeracao')
            ->when((bool) $tipo, fn($query) => $query->where('tipo', $tipo))
            ->get();
    }

    public static function lancamentos($filters) {
        $query = FinanceiroLancamento::query();

        // Filtrar por caixa
        if (isset($filters['caixa_id'])) {
            $query->where('caixa_id', $filters['caixa_id']);
        }

        // Filtrar por plano de contas
        if (isset($filters['plano_conta_id'])) {
            $query->where('plano_conta_id', $filters['plano_conta_id']);
        }

        // Filtrar por data inicial
        if (isset($filters['d1'])) {
            $query->whereDate('data_lancamento', '>=', Carbon::createFromFormat('d/m/Y', $filters['d1'])->format('Y-m-d'));
        }

        // Filtrar por data final
        if (isset($filters['d2'])) {
            $query->whereDate('data_lancamento', '<=', Carbon::createFromFormat('d/m/Y', $filters['d2'])->format('Y-m-d'));
        }

        return $query->where('instituicao_id', session()->get('session_perfil')->instituicao_id)
            ->where('conciliado', 0)
            ->orWhereNull('conciliado')
            ->get();
    }

    public static function caixas()
    {
        return FinanceiroCaixa::where('instituicao_id', session()->get('session_perfil')->instituicao_id)
            ->get();
    }

    public static function membros() 
    {
        return MembresiaMembro::where('igreja_id', session()->get('session_perfil')->instituicao_id)
            ->where('vinculo', MembresiaMembro::VINCULO_MEMBRO)
            ->where('status', MembresiaMembro::STATUS_ATIVO)
            ->get();
    }

    public static function fornecedores() 
    {
        return FinanceiroFornecedores::where('instituicao_id', session()->get('session_perfil')->instituicao_id)
            ->get();
    }
    
}