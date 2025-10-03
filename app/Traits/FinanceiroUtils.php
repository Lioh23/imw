<?php

namespace App\Traits;

use App\Calculators\ImpostoDeRenda\ImpostoDeRendaSimplificadoCalculator;
use App\Models\FinanceiroCaixa;
use App\Models\FinanceiroFornecedores;
use App\Models\FinanceiroLancamento;
use App\Models\FinanceiroPlanoConta;
use App\Models\FinanceiroSaldoConsolidadoMensal;
use App\Models\InstituicoesInstituicao;
use App\Models\MembresiaMembro;
use App\Models\PessoasPrebenda;
use App\Services\ServiceClerigosImpostoDeRenda\CalculaImpostoDeRendaService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait FinanceiroUtils
{
    public static function lancamentosPorContas()
    {
        return  DB::table('financeiro_plano_contas as pc')
            ->select(
                'pc.numeracao as numeracao_conta',
                'pc.nome as nome_conta',
                'c.descricao as descricao_caixa',
                DB::raw('SUM(IF(l.valor IS NOT NULL AND l.valor != 0, l.valor, 0)) as total_lancamentos')
            )
            ->leftJoin('financeiro_lancamentos as l', 'pc.id', '=', 'l.plano_conta_id')
            ->leftJoin('financeiro_caixas as c', 'l.caixa_id', '=', 'c.id')
            ->where('l.conciliado', 0)
            ->where('l.instituicao_id', '=', session()->get('session_perfil')->instituicao_id)
            ->groupBy('pc.numeracao', 'pc.nome', 'c.descricao')
            ->havingRaw('total_lancamentos > 0')
            ->orderBy('pc.numeracao')
            ->orderBy('pc.nome')
            ->orderBy('c.descricao')
            ->get();
    }


    public static function planoContas($tipo = null)
    {
        $tpinstituicao = InstituicoesInstituicao::where('id', session()->get('session_perfil')->instituicao_id)->first();
        $tpinstituicao = $tpinstituicao->tipo_instituicao_id;

        return FinanceiroPlanoConta::orderBy('numeracao')
            ->when((bool) $tipo, fn ($query) => $query->where('tipo', $tipo))
            ->whereHas('tiposInstituicoes', fn ($query) => $query->where('tipo_instituicao_id', $tpinstituicao))
            ->get();
    }

    public static function lancamentos($filters)
    {
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
            ->where(function ($query) {
                $query->where('conciliado', 0)
                    ->orWhereNull('conciliado');
            })
            ->orderBy('data_movimento', 'desc')
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

    public static function ultimoCaixaConciliado($mesAno = null)
    {
        $query = FinanceiroSaldoConsolidadoMensal::where('instituicao_id', session()->get('session_perfil')->instituicao_id);

        if ($mesAno) {
            list($mes, $ano) = explode('/', $mesAno);
            $ultimoDiaMes = Carbon::createFromFormat('Y-m', $ano . '-' . $mes)->endOfMonth();
            $query->where('data_hora', '<', $ultimoDiaMes);
        }

        $saldo = $query->orderBy('ano', 'desc')
            ->orderBy('mes', 'desc')
            ->first();

        if ($saldo) {
            return Carbon::create($saldo->ano, $saldo->mes, 1);
        }

        return null;
    }

    public static function cotasOrcamentarias($dados)
    {
        $ano = $dados['ano'] ? $dados['ano'] : '';
        $mes = $dados['mes'] ? $dados['mes'] : '';
        $tipo = $dados['tipo'];
        if($ano){
            $sqlDataLancamento = " AND YEAR(fl.data_lancamento) = $ano AND MONTH(fl.data_lancamento) = $mes ";
        }else{
            $sqlDataLancamento = "";
        }
        if($tipo == 'igreja'){
            $instituicao_id = $dados['instituicao_id'] ? $dados['instituicao_id'] : '';
            $cotas = FinanceiroLancamento::
                select(
                    DB::raw("(SELECT SUM(valor) FROM financeiro_lancamentos fl
                        JOIN financeiro_plano_contas fpc ON fpc.id = fl.plano_conta_id
                        WHERE fpc.numeracao in ('1.01.01', '1.02.01') AND fl.instituicao_id = $instituicao_id $sqlDataLancamento) AS dizimos_ofertas"),
                    DB::raw("(SELECT SUM(valor) FROM financeiro_lancamentos fl
                        JOIN financeiro_plano_contas fpc ON fpc.id = fl.plano_conta_id
                        WHERE fpc.numeracao in ('2.18.23') AND fl.instituicao_id = $instituicao_id $sqlDataLancamento)  AS dizimos_pastoral_fiw")
                )
                ->first();
                $somaImposto = 0;
                if($ano){
                    $prebendasAll = ContabilidadeDados::fetchPrebandasCotaOrcamentaria($dados);                
                    foreach($prebendasAll as $item){
                        $prebenda = PessoasPrebenda::where('id', $item->id)->first();
                        $irCalculator =  new ImpostoDeRendaSimplificadoCalculator();
                        $impostoCalculado = (new CalculaImpostoDeRendaService($irCalculator))->execute($prebenda);
                        $somaImposto += $impostoCalculado->valorImposto;
                    }
                }
            $cotas['irrf_titular'] = $somaImposto;
            return $cotas;
        }else if($tipo == 'distrito'){
            $distritoId = $dados['instituicao_id'] ? $dados['instituicao_id'] : '';
            $instituicoes = InstituicoesInstituicao::select('instituicoes_instituicoes.*','instituicoes_tiposinstituicao.nome as tipo_instituicao')->where('instituicao_pai_id', $distritoId)->join('instituicoes_tiposinstituicao','instituicoes_tiposinstituicao.id', 'instituicoes_instituicoes.tipo_instituicao_id')->get();
            foreach($instituicoes as $instituicao){
                $instituicao_id = $instituicao->id;
                $cotas = FinanceiroLancamento::
                        select(
                            DB::raw("(SELECT SUM(valor) FROM financeiro_lancamentos fl
                                JOIN financeiro_plano_contas fpc ON fpc.id = fl.plano_conta_id
                                WHERE fpc.numeracao in ('1.01.01', '1.02.01') AND fl.instituicao_id = $instituicao_id $sqlDataLancamento) AS dizimos_ofertas"),
                            DB::raw("(SELECT SUM(valor) FROM financeiro_lancamentos fl
                                JOIN financeiro_plano_contas fpc ON fpc.id = fl.plano_conta_id
                                WHERE fpc.numeracao in ('2.18.23') AND fl.instituicao_id = $instituicao_id $sqlDataLancamento)  AS dizimos_pastoral_fiw")
                        )
                        ->first();
                        $somaImposto = 0;
                        if($ano){
                            $prebendasAll = ContabilidadeDados::fetchPrebandasCotaOrcamentaria($dados);                
                            foreach($prebendasAll as $item){
                                $prebenda = PessoasPrebenda::where('id', $item->id)->first();
                                $irCalculator =  new ImpostoDeRendaSimplificadoCalculator();
                                $impostoCalculado = (new CalculaImpostoDeRendaService($irCalculator))->execute($prebenda);
                                $somaImposto += $impostoCalculado->valorImposto;
                            }
                        }
                $cotas['instituicao_nome'] = $instituicao->nome;
                $cotas['tipo_instituicao'] = $instituicao->tipo_instituicao;
                $cotas['irrf_titular'] = $somaImposto;
                $cotasTotal['cotas'][] = $cotas;
            }
            return $cotasTotal;
        }else if($tipo == 'regiao'){
            $regiaoId = $dados['instituicao_id'] ? $dados['instituicao_id'] : '';
            $instituicoesDistritos = InstituicoesInstituicao::select('instituicoes_instituicoes.*','instituicoes_tiposinstituicao.nome as tipo_instituicao')->where(['instituicao_pai_id' => $regiaoId, 'tipo_instituicao_id' => 2])->join('instituicoes_tiposinstituicao','instituicoes_tiposinstituicao.id', 'instituicoes_instituicoes.tipo_instituicao_id')->get();
            foreach($instituicoesDistritos as $distrito){
                $instituicoes = InstituicoesInstituicao::select('instituicoes_instituicoes.*','instituicoes_tiposinstituicao.nome as tipo_instituicao')->where('instituicao_pai_id', $distrito->id)->join('instituicoes_tiposinstituicao','instituicoes_tiposinstituicao.id', 'instituicoes_instituicoes.tipo_instituicao_id')->get();
                foreach($instituicoes as $instituicao){
                    $instituicao_id = $instituicao->id;
                    $cotas = FinanceiroLancamento::
                            select(
                                DB::raw("(SELECT SUM(valor) FROM financeiro_lancamentos fl
                                    JOIN financeiro_plano_contas fpc ON fpc.id = fl.plano_conta_id
                                    WHERE fpc.numeracao in ('1.01.01', '1.02.01') AND fl.instituicao_id = $instituicao_id $sqlDataLancamento) AS dizimos_ofertas"),
                                DB::raw("(SELECT SUM(valor) FROM financeiro_lancamentos fl
                                    JOIN financeiro_plano_contas fpc ON fpc.id = fl.plano_conta_id
                                    WHERE fpc.numeracao in ('2.18.23') AND fl.instituicao_id = $instituicao_id $sqlDataLancamento)  AS dizimos_pastoral_fiw")
                            )
                            ->first();
                            $somaImposto = 0;
                            if($ano){
                                $prebendasAll = ContabilidadeDados::fetchPrebandasCotaOrcamentaria($dados);                
                                foreach($prebendasAll as $item){
                                    $prebenda = PessoasPrebenda::where('id', $item->id)->first();
                                    $irCalculator =  new ImpostoDeRendaSimplificadoCalculator();
                                    $impostoCalculado = (new CalculaImpostoDeRendaService($irCalculator))->execute($prebenda);
                                    $somaImposto += $impostoCalculado->valorImposto;
                                }
                            }
                    $cotas['distrito_nome'] = $distrito->nome;
                    $cotas['instituicao_nome'] = $instituicao->nome;
                    $cotas['tipo_instituicao'] = $instituicao->tipo_instituicao;
                    $cotas['irrf_titular'] = $somaImposto;
                    $cotasTotal['cotas'][] = $cotas;
                }
            }
            return $cotasTotal;
        }
    }
    
}
