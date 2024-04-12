<?php

namespace App\Traits;

use App\Models\FinanceiroCaixa;
use App\Models\FinanceiroFornecedores;
use App\Models\FinanceiroPlanoConta;
use App\Models\MembresiaMembro;

trait FinanceiroUtils
{
    public static function planoContas($tipo = null)
    {
        return FinanceiroPlanoConta::orderBy('numeracao')
            ->when((bool) $tipo, fn($query) => $query->where('tipo', $tipo))
            ->get();
    }

    public static function caixas()
    {
        return FinanceiroCaixa::where('instituicao_id', session()->get('session_perfil')->instituicao_id)
            ->get();
    }

    public static function membros() 
    {
        return MembresiaMembro::select('id', 'nome')
            ->where('igreja_id', session()->get('session_perfil')->instituicao_id)
            ->where('vinculo'. 'M')
            ->where('status', 'A')
            ->get();
    }

    public static function fornecedores() 
    {
        return FinanceiroFornecedores::select('id', 'nome')
            ->where('instituicao_id', session()->get('session_perfil')->instituicao_id)
            ->get();
    }
}