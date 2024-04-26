<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceiroCaixa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'financeiro_caixas';

    protected $fillable = ['descricao', 'instituicao_id', 'tipo'];

    const IDS_TRANFERENCIA = [100002, 100003, 110095, 110096, 110097, 110098, 110120, 110121, 110128, 110137];

    public function lancamentos()
    {
        return $this->hasMany(FinanceiroLancamento::class, 'caixa_id');
    }

    public function saldoAtualNaoConciliado()
    {
        $totalEntrada = $this->totalLancamentosNaoConciliadosEntrada() + $this->totalLancamentosNaoConciliadosTransferenciaEntrada();
        $totalSaida = $this->totalLancamentosNaoConciliadosSaida() + $this->totalLancamentosNaoConciliadosTransferenciaSaida();
        $ultimoConciliado = $this->totalLancamentosUltimosConciliados();

        return $totalEntrada - $totalSaida + $ultimoConciliado;
    }

    public function totalLancamentosNaoConciliados()
    {
        return $this->lancamentos()
            ->where('conciliado', 0)
            ->where('instituicao_id', session()->get('session_perfil')->instituicao_id)
            ->sum('valor');
    }

    public function totalLancamentosNaoConciliadosTransferenciaEntrada()
    {
        return $this->lancamentos()
            ->whereIn('plano_conta_id', self::IDS_TRANFERENCIA)
            ->where('conciliado', 0)
            ->where('tipo_lancamento', FinanceiroLancamento::TP_LANCAMENTO_ENTRADA)
            ->where('instituicao_id', session()->get('session_perfil')->instituicao_id)
            ->sum('valor');
    }

    public function totalLancamentosNaoConciliadosTransferenciaSaida()
    {
        return $this->lancamentos()
            ->whereIn('plano_conta_id', self::IDS_TRANFERENCIA)
            ->where('conciliado', 0)
            ->where('tipo_lancamento', FinanceiroLancamento::TP_LANCAMENTO_SAIDA)
            ->where('instituicao_id', session()->get('session_perfil')->instituicao_id)
            ->sum('valor');
    }

    public function totalLancamentosNaoConciliadosEntrada()
    {
        return $this->lancamentos()
            ->whereNotIn('plano_conta_id', self::IDS_TRANFERENCIA)
            ->where('conciliado', 0)
            ->where('tipo_lancamento', FinanceiroLancamento::TP_LANCAMENTO_ENTRADA)
            ->where('instituicao_id', session()->get('session_perfil')->instituicao_id)
            ->sum('valor');
    }

    public function totalLancamentosNaoConciliadosSaida()
    {
        return $this->lancamentos()
            ->whereNotIn('plano_conta_id', self::IDS_TRANFERENCIA)
            ->where('conciliado', 0)
            ->where('tipo_lancamento', FinanceiroLancamento::TP_LANCAMENTO_SAIDA)
            ->where('instituicao_id', session()->get('session_perfil')->instituicao_id)
            ->sum('valor');
    }


    public function totalLancamentosUltimosConciliados()
    {
        $saldo = FinanceiroSaldoConsolidadoMensal::where('caixa_id', $this->id)
            ->where('instituicao_id', session()->get('session_perfil')->instituicao_id)
            ->orderBy('data_hora', 'desc')
            ->first();

        if (!$saldo) {
            return 0;
        }

        return $saldo->saldo_final;
    }
}
