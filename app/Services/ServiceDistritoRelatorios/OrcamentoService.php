<?php

namespace App\Services\ServiceDistritoRelatorios;

use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrcamentoService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute($dtano)
    {
        if (empty($dtano)) {
            $dtano = Carbon::now()->format('Y');
        }

        $lancamentos = $this->handleLancamentos($dtano);

        return [
            'lancamentos' => $lancamentos
        ];
    }

    private function handleLancamentos($ano)
    {
        $instituicaoPaiId = session()->get('session_perfil')->instituicao_id; 

        $result = DB::table('instituicoes_instituicoes as ii')
            ->leftJoin('financeiro_lancamentos as fl', function ($join) use ($ano) {
                $join->on('ii.id', '=', 'fl.instituicao_id')
                    ->whereYear('fl.data_movimento', '=', $ano)
                    ->whereIn('fl.plano_conta_id', [4, 5, 8])
                    ->where('fl.conciliado', '=', 1);
            })
            ->select(
                'ii.nome as instituicao_nome',
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 1 THEN fl.valor ELSE 0 END) AS janeiro'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 2 THEN fl.valor ELSE 0 END) AS fevereiro'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 3 THEN fl.valor ELSE 0 END) AS marco'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 4 THEN fl.valor ELSE 0 END) AS abril'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 5 THEN fl.valor ELSE 0 END) AS maio'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 6 THEN fl.valor ELSE 0 END) AS junho'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 7 THEN fl.valor ELSE 0 END) AS julho'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 8 THEN fl.valor ELSE 0 END) AS agosto'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 9 THEN fl.valor ELSE 0 END) AS setembro'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 10 THEN fl.valor ELSE 0 END) AS outubro'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 11 THEN fl.valor ELSE 0 END) AS novembro'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM fl.data_movimento) = 12 THEN fl.valor ELSE 0 END) AS dezembro')
            )
            ->where('ii.instituicao_pai_id', '=', $instituicaoPaiId)
            ->groupBy('ii.nome')
            ->orderBy('ii.nome')
            ->get();


        return $result;
    }
}
