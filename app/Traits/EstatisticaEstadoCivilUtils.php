<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait EstatisticaEstadoCivilUtils
{
    public static function fetch($distritoId, $regiaoId = null): Collection
    {

        $estadosCivis = collect([
            (object) ['estado_civil' => 'S', 'descricao' => 'Solteiro'],
            (object) ['estado_civil' => 'C', 'descricao' => 'Casado'],
            (object) ['estado_civil' => 'V', 'descricao' => 'Viúvo'],
            (object) ['estado_civil' => 'D', 'descricao' => 'Divorciado'],
            (object) ['estado_civil' => 'N', 'descricao' => 'Não informado'],
        ]);


        $query = DB::table('membresia_membros as mm')
            ->leftJoin('membresia_rolpermanente as mr', function ($join) {
                $join->on('mr.membro_id', '=', 'mm.id')
                    ->whereNull('mr.dt_exclusao');
            })
            ->selectRaw('COUNT(mm.id) as total, COALESCE(mm.estado_civil, "N") as estado_civil');


        if ($distritoId != "all") {
            $query->where('mm.distrito_id', $distritoId);
        } else {
            $query->where('mm.regiao_id', $regiaoId);
        }

        $query->groupBy(DB::raw('COALESCE(mm.estado_civil, "N")'));

        $result = $query->get()->keyBy('estado_civil');

        $finalResult = $estadosCivis->map(function ($estado) use ($result) {
            return (object) [
                'estado_civil' => $estado->descricao,
                'total' => $result->has($estado->estado_civil) ? $result[$estado->estado_civil]->total : 0
            ];
        });


        $totalGeral = $finalResult->sum('total');
        $finalResult = $finalResult->map(function ($item) use ($totalGeral) {
            $item->percentual = ($totalGeral > 0) ? ($item->total * 100) / $totalGeral : 0;
            return $item;
        });

        return $finalResult;
    }
}
