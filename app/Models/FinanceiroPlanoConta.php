<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceiroPlanoConta extends Model
{
    use HasFactory, SoftDeletes;

    const TP_ENTRADA = 'E';
    const TP_SAIDA = 'S';
    const TP_TRANSFERENCIA = 'T';
    const TP_R = 'R';

    protected $table = 'financeiro_plano_contas';

    protected $fillable = [
        'nome',
        'posicao',
        'numeracao',
        'tipo',
        'conta_pai_id',
        'selecionavel',
        'essencial',
    ];

    public function lancamentos()
    {
        return $this->hasMany(FinanceiroLancamento::class, 'caixa_id');
    }

    
    public function totalLancamentos()
    {
        return $this->lancamentos()
            ->where('conciliado', 0)
            ->sum('valor');
    }
}
