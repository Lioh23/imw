<?php

namespace App\Traits;

use App\Models\VwEstatisticaEscolaridade;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait EstatisticaGeneroPorcentagemUtils
{
    public static function fetch($distritoId, $regiaoId = null): Collection
    {
        $query = DB::table('membresia_membros as mm')
            ->leftJoin('membresia_rolpermanente as mr', function ($join) {
                $join->on('mr.membro_id', '=', 'mm.id')
                    ->whereNull('mr.dt_exclusao');
            })
            ->selectRaw('COALESCE(mm.sexo, "Não informado") as sexo, COUNT(mm.id) as total')
            ->where('mm.status', 'A')
            ->whereIn('mm.vinculo', ['M'])
            ->groupBy('sexo');

        if ($distritoId !== "all") {
            $query->where('mm.distrito_id', $distritoId);
        } elseif ($regiaoId !== null) {
            $query->where('mm.regiao_id', $regiaoId);
        }

        $result = $query->get();


        $totais = [
            'M' => 0,
            'F' => 0,
            'Não informado' => 0
        ];

        foreach ($result as $item) {
            $totais[$item->sexo] = $item->total;
        }

        $totalGeral = array_sum($totais);


        $estatisticas = collect([
            (object) [
                'sexo' => 'Masculino',
                'total' => $totais['M'],
                'percentual' => ($totalGeral > 0) ? ($totais['M'] * 100) / $totalGeral : 0
            ],
            (object) [
                'sexo' => 'Feminino',
                'total' => $totais['F'],
                'percentual' => ($totalGeral > 0) ? ($totais['F'] * 100) / $totalGeral : 0
            ],
            (object) [
                'sexo' => 'Não informado',
                'total' => $totais['Não informado'],
                'percentual' => ($totalGeral > 0) ? ($totais['Não informado'] * 100) / $totalGeral : 0
            ]
        ]);

        return $estatisticas;
    }
}
