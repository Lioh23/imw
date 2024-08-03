<?php

namespace App\Models;

use App\Traits\Identifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceiroPlanoConta extends Model
{
    use HasFactory, SoftDeletes, Identifiable;

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

    public function lancamentosPorIgreja()
    {
        return $this->hasMany(FinanceiroLancamento::class, 'plano_conta_id')
            ->where('instituicao_id', Identifiable::fetchSessionIgrejaLocal()->id);

    }

    public function tiposInstituicoes()
    {
        return $this->hasMany(FinanceiroPlanoContaTipoInstituicao::class, 'plano_conta_id');
    }
}
