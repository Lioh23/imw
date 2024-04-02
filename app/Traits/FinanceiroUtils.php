<?php

namespace App\Traits;

use App\Models\FinanceiroCaixa;
use App\Models\FinanceiroPlanoConta;

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
}