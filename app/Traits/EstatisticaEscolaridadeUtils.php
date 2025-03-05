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
        if ($distritoId != "all") {
            $result = DB::table('membresia_formacoes as mf')
                ->leftJoin('membresia_membros as mm', function ($join) use ($distritoId) {
                    $join->on('mm.escolaridade_id', '=', 'mf.id')
                        ->where('mm.distrito_id', $distritoId)
                        ->where('mm.status', 'A')
                        ->whereIn('mm.vinculo', ['M']);
                })
                ->leftJoin('membresia_rolpermanente as mr', function ($join) {
                    $join->on('mr.membro_id', '=', 'mm.id')
                        ->whereNull('mr.dt_exclusao');
                })
                ->selectRaw('
                    COALESCE(mf.descricao, "Não informado") as escolaridade,
                    COALESCE(count(mm.id), 0) as total
                ')
                ->groupBy('mf.descricao')
                ->union(
                    DB::table('membresia_membros as mm')
                        ->leftJoin('membresia_rolpermanente as mr', function ($join) {
                            $join->on('mr.membro_id', '=', 'mm.id')
                                ->whereNull('mr.dt_exclusao');
                        })
                        ->selectRaw('"Não informado" as escolaridade, count(mm.id) as total')
                        ->whereNull('mm.escolaridade_id')
                        ->where('mm.status', 'A')
                        ->whereIn('mm.vinculo', ['M'])
                )
                ->get();
        } else {
            $result = DB::table('membresia_formacoes as mf')
            ->leftJoin('membresia_membros as mm', function ($join) use ($regiaoId) {
                $join->on('mm.escolaridade_id', '=', 'mf.id')
                    ->where('mm.regiao_id', $regiaoId)
                    ->where('mm.status', 'A')
                    ->whereIn('mm.vinculo', ['M']);
            })
            ->leftJoin('membresia_rolpermanente as mr', function ($join) {
                $join->on('mr.membro_id', '=', 'mm.id')
                    ->whereNull('mr.dt_exclusao');
            })
            ->selectRaw('
                COALESCE(mf.descricao, "Não informado") as escolaridade,
                COALESCE(count(mm.id), 0) as total
            ')
            ->groupBy('mf.descricao')
            ->union(
                DB::table('membresia_membros as mm')
                    ->leftJoin('membresia_rolpermanente as mr', function ($join) {
                        $join->on('mr.membro_id', '=', 'mm.id')
                            ->whereNull('mr.dt_exclusao');
                    })
                    ->selectRaw('"Não informado" as escolaridade, count(mm.id) as total')
                    ->whereNull('mm.escolaridade_id')
                    ->where('mm.status', 'A')
                    ->whereIn('mm.vinculo', ['M'])
            )
            ->get();
        }

        $total = $result->sum('total');

        $escolaridadesComPercentual = $result->map(function ($escolaridade) use ($total) {
            if (empty($escolaridade->escolaridade)) {
                $escolaridade->escolaridade = "Não informado";
            }
            $escolaridade->percentual = ($total > 0) ? ($escolaridade->total * 100) / $total : 0;
            return $escolaridade;
        });

        return $escolaridadesComPercentual;
    }
}
