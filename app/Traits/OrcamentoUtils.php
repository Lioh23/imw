<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait OrcamentoUtils
{
	public static function fetch($ano, $distritoId, $regiaoId = null): Collection
	{
        $result = DB::table('instituicoes_instituicoes as ii')
            ->join('instituicoes_instituicoes as dist', 'dist.id', '=', 'ii.instituicao_pai_id')
            ->leftJoin('financeiro_lancamentos as fl', function ($join) use ($ano) {
                $join->on('ii.id', '=', 'fl.instituicao_id')
                    ->whereYear('fl.data_movimento', '=', $ano)
                    ->whereIn('fl.plano_conta_id', [4, 5, 8])
                    ->where('fl.conciliado', '=', 1);
            })
            ->select(
                'dist.nome as distrito_nome',
                'ii.nome as instituicao_nome',
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 1 THEN fl.valor ELSE 0 END) AS janeiro'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 2 THEN fl.valor ELSE 0 END) AS fevereiro'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 3 THEN fl.valor ELSE 0 END) AS marco'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 4 THEN fl.valor ELSE 0 END) AS abril'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 5 THEN fl.valor ELSE 0 END) AS maio'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 6 THEN fl.valor ELSE 0 END) AS junho'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 7 THEN fl.valor ELSE 0 END) AS julho'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 8 THEN fl.valor ELSE 0 END) AS agosto'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 9 THEN fl.valor ELSE 0 END) AS setembro'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 10 THEN fl.valor ELSE 0 END) AS outubro'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 11 THEN fl.valor ELSE 0 END) AS novembro'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 12 THEN fl.valor ELSE 0 END) AS dezembro')
            )
            ->when($distritoId == 'all' && $regiaoId, 
                fn ($query) => $query->whereIn('ii.instituicao_pai_id', Identifiable::fetchDistritosIdByRegiao($regiaoId)),
                fn ($query) => $query->where('ii.instituicao_pai_id', $distritoId)
            )
            ->groupBy('dist.nome')
            ->groupBy('ii.nome')
            ->orderBy('dist.nome')
            ->orderBy('ii.nome')
            ->get();

        return $result;
    }
}