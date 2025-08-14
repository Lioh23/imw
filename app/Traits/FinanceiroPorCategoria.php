<?php

namespace App\Traits;

use App\Models\FinanceiroPlanoContaCategoria;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait FinanceiroPorCategoria
{
    public static function fetch($dataInicial, $dataFinal, $regiao, $categoriaId)
    {
        $dadosDistritosTotalGeral = DB::table('financeiro_lancamentos as fl')
            ->select(
                DB::raw("IFNULL(SUM(fl.valor), 0.0) AS valor")
            )
            ->join('financeiro_plano_contas as fpl', function ($join) {
                $join->on('fpl.id', '=', 'fl.plano_conta_id');
            })
            ->join('financeiro_plano_contas_categoria as fpcc', function ($join) {
                $join->on('fpcc.id', '=', 'fpl.plano_contas_categoria_id');
            })
            ->join('instituicoes_instituicoes as ii', function ($join) {
                $join->on('ii.id', '=', 'fl.instituicao_id');
            })
            ->join('instituicoes_instituicoes as iip', function ($join) {
                $join->on('iip.id', '=', 'ii.instituicao_pai_id');
            })
            ->where(['fpl.plano_contas_categoria_id' => $categoriaId, 'iip.instituicao_pai_id' => $regiao->id])
            ->whereBetween('fl.data_movimento', [$dataInicial, $dataFinal])
            ->first();
        
        $dadosDistritos = DB::table('financeiro_lancamentos as fl')
            ->select(
                'iip.id',
                'iip.nome AS distrito',
                DB::raw("IFNULL(SUM(fl.valor), 0.0) AS valor")
            )
            ->join('financeiro_plano_contas as fpl', function ($join) {
                $join->on('fpl.id', '=', 'fl.plano_conta_id');
            })
            ->join('financeiro_plano_contas_categoria as fpcc', function ($join) {
                $join->on('fpcc.id', '=', 'fpl.plano_contas_categoria_id');
            })
            ->join('instituicoes_instituicoes as ii', function ($join) {
                $join->on('ii.id', '=', 'fl.instituicao_id');
            })
            ->join('instituicoes_instituicoes as iip', function ($join) {
                $join->on('iip.id', '=', 'ii.instituicao_pai_id');
            })
            ->where(['fpl.plano_contas_categoria_id' => $categoriaId, 'iip.instituicao_pai_id' => $regiao->id])
            ->whereBetween('fl.data_movimento', [$dataInicial, $dataFinal])
            ->orderBy('iip.nome')
            ->groupBy('iip.nome', 'iip.id')
            ->get();
        if($dadosDistritos->count() > 1){
            foreach($dadosDistritos as $distrito){
                $dadosIgrejas = DB::table('financeiro_lancamentos as fl')
                    ->select(
                        'ii.nome AS igreja',
                        'fpcc.nome',
                        DB::raw("IFNULL(SUM(fl.valor), 0.0) AS valor")
                    )
                    ->join('financeiro_plano_contas as fpl', function ($join) {
                        $join->on('fpl.id', '=', 'fl.plano_conta_id');
                    })
                    ->join('financeiro_plano_contas_categoria as fpcc', function ($join) {
                        $join->on('fpcc.id', '=', 'fpl.plano_contas_categoria_id');
                    })
                    ->join('instituicoes_instituicoes as ii', function ($join) {
                        $join->on('ii.id', '=', 'fl.instituicao_id');
                    })
                    ->join('instituicoes_instituicoes as iip', function ($join) {
                        $join->on('iip.id', '=', 'ii.instituicao_pai_id');
                    })
                    ->where(['fpl.plano_contas_categoria_id' => $categoriaId, 'iip.id' => $distrito->id])
                    ->whereBetween('fl.data_movimento', [$dataInicial, $dataFinal])
                    ->orderBy('iip.nome')
                    ->groupBy('iip.nome', 'ii.nome', 'fpcc.nome')
                    ->get();
                foreach($dadosIgrejas as $igreja){
                    $igrejas[] = $igreja;
                }
            $dados['dados'][] = (object)['distrito' => (object)$distrito, 'igrejas' => (object)$igrejas];
            unset($igrejas);
            }
            $dados['TotalGeral'] = $dadosDistritosTotalGeral;
        }else{
            $dados = [];
        }
        return $dados;
    }

    public static function categorias()
    {
        return FinanceiroPlanoContaCategoria::orderBy('nome', 'ASC')->get();
    }
    
    public static function categoria($id)
    {
        return FinanceiroPlanoContaCategoria::where('id', $id)->first();
    }
}
