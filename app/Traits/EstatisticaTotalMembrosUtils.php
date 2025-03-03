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
        if ($regiaoId != "all") {;
            $result = DB::table('membresia_membros as mm')
                ->join('membresia_rolpermanente as mr', function ($join) {
                    $join->on('mr.membro_id', '=', 'mm.id')
                        ->whereNull('mr.dt_exclusao');
                })
                ->join('instituicoes_instituicoes as ii', 'mm.distrito_id', '=', 'ii.id')
                ->select(DB::raw('count(*) as total'), 'mm.distrito_id', 'mm.regiao_id', 'ii.nome as instituicao')
                ->groupBy('mm.distrito_id', 'mm.regiao_id', 'ii.nome')
                ->where('mm.regiao_id', $regiaoId)
                ->orderByDesc(DB::raw('count(*)'))
                ->get();
        } else {
            $result = DB::table('membresia_membros as mm')
                ->join('membresia_rolpermanente as mr', function ($join) {
                    $join->on('mr.membro_id', '=', 'mm.id')
                        ->whereNull('mr.dt_exclusao');
                })
                ->join('instituicoes_instituicoes as ii', 'ii.id', '=', 'mm.distrito_id')
                ->join('instituicoes_instituicoes as ii_nome', 'ii_nome.id', '=', 'ii.regiao_id')
                ->select(
                    DB::raw('count(mm.id) as total'),
                    'ii.regiao_id',
                    'ii_nome.nome as instituicao'
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
