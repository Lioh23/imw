<?php

namespace App\Traits;

use App\Models\VwEstatisticaEscolaridade;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait EstatisticaEstadoCivilUtils
{
    public static function fetch($distritoId, $estadoCivil ,$regiaoId = null): Collection
    {

        $result = [];
        // Condicional para filtrar por distrito ou por região
        if ($distritoId != "all") {
            // Quando é passado um distrito, filtramos por distrito
            $result = DB::table('membresia_membros as mm')
            ->selectRaw('count(*) as total, mm.distrito_id, mm.regiao_id, ii.nome as instituicao')
            ->join('instituicoes_instituicoes as ii', 'mm.distrito_id', '=', 'ii.id')
            ->where('mm.estado_civil', $estadoCivil)
            ->where('mm.distrito_id', $distritoId)
            ->groupBy('mm.distrito_id', 'mm.regiao_id', 'ii.nome')
            ->orderByDesc('total')
            ->get();
        } else {
            // Quando não é passado um distrito, filtramos por região
            $result = DB::table('membresia_membros as mm')
                ->selectRaw('count(*) as total, mm.distrito_id, mm.regiao_id, ii.nome as instituicao')
                ->join('instituicoes_instituicoes as ii', 'mm.distrito_id', '=', 'ii.id')
                ->where('mm.estado_civil', $estadoCivil)
                ->where('mm.regiao_id', $regiaoId)
                ->groupBy('mm.distrito_id', 'mm.regiao_id', 'ii.nome')
                ->orderByDesc('total')
                ->get();
        }


        // Calculando o total absoluto
        $total = $result->sum('total');

        // Adicionando o percentual em cada estadocivil
        $estadocivilComPercentual = $result->map(function ($estadocivil) use ($total) {
            $estadocivil->percentual = ($total > 0) ? ($estadocivil->total * 100) / $total : 0;
            return $estadocivil;
        });

        // Retornar os dados com percentual calculado
        return $estadocivilComPercentual;
    }
}
