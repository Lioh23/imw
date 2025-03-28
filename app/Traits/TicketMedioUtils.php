<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait TicketMedioUtils
{

    public static function execute()
    {
        return self::fetch();
    }

    private static function fetch()
    {
        $query = "SELECT
                    sum(fl.valor) as valor
                    , fl.instituicao_id as igreja_id
                    , ii.nome as igreja
                    , dist.id as distrito_id
                    , dist.nome as distrito
                    , count(mm.nome) as total_membros
                    , count(DISTINCT ii.id) as total_igrejas
                from financeiro_lancamentos fl
                inner join financeiro_plano_contas fpc
                on fpc.id = fl.plano_conta_id
                inner join instituicoes_instituicoes ii
                on ii.id = fl.instituicao_id and ii.tipo_instituicao_id = 1
                inner join instituicoes_instituicoes dist
                on dist.id = ii.instituicao_pai_id
                left join membresia_membros mm
                on mm.igreja_id = ii.id
                where fpc.conta_pai_id = 52
                group by  fl.instituicao_id
                    , ii.nome
                    , dist.id
                    , dist.nome";

        $results = collect(DB::select($query));
        $valorTotal = $results->sum('valor');

        return $results
            ->groupBy('distrito')
            ->map(function ($items, $key) use ($valorTotal) {
                $totalDistrito = collect($items)->sum('valor');
                $totalIgrejasDistrito = collect($items)->first()->total_igrejas;
                $totalMembrosDistrito = collect($items)->first()->total_membros;

                $items = collect($items)->map(function ($item) use ($valorTotal, $totalIgrejasDistrito, $totalMembrosDistrito) {
                    // Evitar divisão por zero
                    $ticketMedioIgreja = $totalIgrejasDistrito > 0 ? $item->valor / $totalIgrejasDistrito : 0;
                    $ticketMedioMembro = $totalMembrosDistrito > 0 ? $item->valor / $totalMembrosDistrito : 0;

                    // Calculando o percentual
                    $percentual = round(($item->valor / $valorTotal) * 100, 2);

                    return (object) [
                        ...(array) $item,
                        "percentual" => $percentual,
                        "ticket_medio_igreja" => $ticketMedioIgreja,
                        "ticket_medio_membro" => $ticketMedioMembro
                    ];
                });

                // Cálculo do percentual do total do distrito
                $distrito = (object) [
                    "distrito" => $key,
                    "distrito_id" => $items[0]->distrito_id,
                    "total_distrito" => $totalDistrito,
                    "percentual" =>  round(($totalDistrito / $valorTotal) * 100, 2),
                    "items" => $items
                ];

                return $distrito;
            })
            ->values();
    }
}
