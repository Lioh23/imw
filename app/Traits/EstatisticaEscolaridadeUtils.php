<?php

namespace App\Traits;

use App\Models\VwEstatisticaEscolaridade;
use Illuminate\Support\Collection;

trait EstatisticaEscolaridadeUtils
{
    public static function fetch($distritoId, $escolaridadeId ,$regiaoId = null): Collection
    {
        // Inicializar a variável para armazenar as escolaridades
        $escolaridades = [];
        // Condicional para filtrar por distrito ou por região
        if ($distritoId != "all") {
            // Quando é passado um distrito, filtramos por distrito
            $escolaridades = VwEstatisticaEscolaridade::where('distrito_id', $distritoId)->where('escolaridade_id', $escolaridadeId)->get();
        } else {
            // Quando não é passado um distrito, filtramos por região
            $escolaridades = VwEstatisticaEscolaridade::where('regiao_id', $regiaoId)->where('escolaridade_id', $escolaridadeId)->get();
        }

        // Calculando o total absoluto
        $total = $escolaridades->sum('total');

        // Adicionando o percentual em cada escolaridade
        $escolaridadesComPercentual = $escolaridades->map(function ($escolaridade) use ($total) {
            $escolaridade->percentual = ($total > 0) ? ($escolaridade->total * 100) / $total : 0;
            return $escolaridade;
        });

        // Retornar os dados com percentual calculado
        return $escolaridadesComPercentual;
    }
}
