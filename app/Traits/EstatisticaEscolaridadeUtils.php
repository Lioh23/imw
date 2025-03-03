<?php

namespace App\Traits;

use App\Models\VwEstatisticaEscolaridade;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait EstatisticaEscolaridadeUtils
{
    public static function fetch($distritoId, $regiaoId = null): Collection
    {
        $result = [];
        if ($distritoId != "all") {;
            $result = DB::table('membresia_formacoes as mf')
                ->leftJoin('membresia_membros as mm', 'mm.escolaridade_id', '=', 'mf.id')
                ->leftJoin('membresia_rolpermanente as mr', function ($join) {
                    $join->on('mr.membro_id', '=', 'mm.id')
                        ->whereNull('mr.dt_exclusao');
                })
                ->select(DB::raw('count(mm.id) as total'), 'mf.descricao as escolaridade')
                ->where('mm.distrito_id', $distritoId)
                ->groupBy('mf.descricao')

                ->get();
        } else {

            $result = DB::table('membresia_formacoes as mf')
                ->leftJoin('membresia_membros as mm', 'mm.escolaridade_id', '=', 'mf.id')
                ->leftJoin('membresia_rolpermanente as mr', function ($join) {
                    $join->on('mr.membro_id', '=', 'mm.id')
                        ->whereNull('mr.dt_exclusao');
                })
                ->select(DB::raw('count(mm.id) as total'), 'mf.descricao as escolaridade')
                ->where('mm.regiao_id', $regiaoId)
                ->groupBy('mf.descricao')

                ->get();
        }


        $total = $result->sum('total');


        $escolaridadesComPercentual = $result->map(function ($escolaridade) use ($total) {
            $escolaridade->percentual = ($total > 0) ? ($escolaridade->total * 100) / $total : 0;
            return $escolaridade;
        });
        return $escolaridadesComPercentual;
    }
}
