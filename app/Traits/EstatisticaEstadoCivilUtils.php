<?php

namespace App\Traits;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait EstatisticaEstadoCivilUtils
{
    public static function fetch($distritoId ,$regiaoId = null): Collection
    {

        $result = [];

        if ($distritoId != "all") {

            $result = DB::table('membresia_membros as mm')
                ->join('membresia_rolpermanente as mr', function ($join) {
                    $join->on('mr.membro_id', '=', 'mm.id')
                        ->whereNull('mr.dt_exclusao');
                })
                ->join('instituicoes_instituicoes as ii', 'ii.id', '=', 'mm.distrito_id')
                ->where('ii.id', $distritoId)
                ->selectRaw('count(mm.id) as total, mm.distrito_id, mm.estado_civil')
                ->groupBy('mm.estado_civil', 'mm.distrito_id')
                ->orderByDesc('total')
                ->get();
        } else {

            $result = DB::table('membresia_membros as mm')
                ->join('membresia_rolpermanente as mr', function ($join) {
                    $join->on('mr.membro_id', '=', 'mm.id')
                        ->whereNull('mr.dt_exclusao');
                })
                ->join('instituicoes_instituicoes as ii', 'ii.id', '=', 'mm.distrito_id')
                ->where('mm.regiao_id', $regiaoId)
                ->selectRaw('count(mm.id) as total, mm.estado_civil, mm.regiao_id')
                ->groupBy('mm.estado_civil', 'mm.regiao_id')
                ->orderByDesc('total')
                ->get();
        }


        $total = $result->sum('total');

        $estadocivilComPercentual = $result->map(function ($estadocivil) use ($total) {
            $estadocivil->percentual = ($total > 0) ? ($estadocivil->total * 100) / $total : 0;
            return $estadocivil;
        });


        return $estadocivilComPercentual;
    }
}
