<?php

namespace App\Traits;

use App\Models\InstituicoesTipoInstituicao;
use App\Models\VwEstatisticaEscolaridade;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait EstatisticaTotalMembrosUtils
{
    public static function fetch($regiaoId): Collection
    {
        $result = [];
        if ($regiaoId != "all") {
            $result = DB::table('instituicoes_instituicoes as ii')
                ->leftJoin('membresia_membros as mm', 'mm.distrito_id', '=', 'ii.id')
                ->leftJoin('membresia_rolpermanente as mr', function ($join) {
                    $join->on('mr.membro_id', '=', 'mm.id')
                        ->whereNull('mr.dt_exclusao');
                })
                ->select(
                    'ii.id as distrito_id',
                    'ii.nome as instituicao',
                    DB::raw('COALESCE(COUNT(mm.id), 0) as total')
                )
                ->where('ii.regiao_id', $regiaoId)
                ->groupBy('ii.id', 'ii.nome')
                ->orderByDesc('total')
                ->get();
        } else {
            $result = DB::table('instituicoes_instituicoes as ii')
                ->leftJoin('membresia_membros as mm', 'mm.distrito_id', '=', 'ii.id')
                ->leftJoin('membresia_rolpermanente as mr', function ($join) {
                    $join->on('mr.membro_id', '=', 'mm.id')
                        ->whereNull('mr.dt_exclusao');
                })
                ->leftJoin('instituicoes_instituicoes as ii_nome', 'ii.regiao_id', '=', 'ii_nome.id')
                ->select(
                    'ii.regiao_id',
                    'ii_nome.nome as instituicao',
                    DB::raw('COALESCE(COUNT(mm.id), 0) as total')
                )
                ->groupBy('ii.regiao_id', 'ii_nome.nome')
                ->orderByDesc('total')
                ->get();
        }

        $total = $result->sum('total');

        $totalMembros = $result->map(function ($escolaridade) use ($total) {
            $escolaridade->percentual = ($total > 0) ? ($escolaridade->total * 100) / $total : 0;
            return $escolaridade;
        });


        return $totalMembros;
    }
}
