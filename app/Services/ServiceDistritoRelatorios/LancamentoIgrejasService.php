<?php

namespace App\Services\ServiceDistritoRelatorios;

use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LancamentoIgrejasService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute($dtano, $igrejasID)
    {
        if (empty($dtano)) {
            $dtano = Carbon::now()->format('Y');
        } 

        // Verifique se $igrejasID é um array, caso contrário, inicialize como um array vazio
        if (!is_array($igrejasID)) {
            $igrejasID = [];
        }

        $igrejaSelect  = $this->handleListaIgrejas();
        $lancamentos = $this->handleLancamentos($dtano, $igrejasID);

        return [
            'igrejaSelect' => $igrejaSelect,
            'lancamentos' => $lancamentos
        ];
    }

    private function handleLancamentos($dtano, $igrejasID)
    {
        $query = DB::table('instituicoes_instituicoes as ii')
            ->leftJoin('financeiro_saldo_consolidado_mensal as cm', function($join) use ($dtano) {
                $join->on('ii.id', '=', 'cm.instituicao_id')
                     ->whereYear('cm.data_hora', '=', $dtano);
            })
            ->leftJoin('instituicoes_instituicoes as parent', 'ii.instituicao_pai_id', '=', 'parent.id')
            ->select(
                'ii.nome as instituicao_nome',
                'parent.nome as instituicao_pai_nome',
                'ii.id',
                DB::raw('COALESCE(SUM(CASE WHEN cm.mes = 1 THEN cm.saldo_final ELSE 0 END), 0) AS janeiro'),
                DB::raw('COALESCE(SUM(CASE WHEN cm.mes = 2 THEN cm.saldo_final ELSE 0 END), 0) AS fevereiro'),
                DB::raw('COALESCE(SUM(CASE WHEN cm.mes = 3 THEN cm.saldo_final ELSE 0 END), 0) AS marco'),
                DB::raw('COALESCE(SUM(CASE WHEN cm.mes = 4 THEN cm.saldo_final ELSE 0 END), 0) AS abril'),
                DB::raw('COALESCE(SUM(CASE WHEN cm.mes = 5 THEN cm.saldo_final ELSE 0 END), 0) AS maio'),
                DB::raw('COALESCE(SUM(CASE WHEN cm.mes = 6 THEN cm.saldo_final ELSE 0 END), 0) AS junho'),
                DB::raw('COALESCE(SUM(CASE WHEN cm.mes = 7 THEN cm.saldo_final ELSE 0 END), 0) AS julho'),
                DB::raw('COALESCE(SUM(CASE WHEN cm.mes = 8 THEN cm.saldo_final ELSE 0 END), 0) AS agosto'),
                DB::raw('COALESCE(SUM(CASE WHEN cm.mes = 9 THEN cm.saldo_final ELSE 0 END), 0) AS setembro'),
                DB::raw('COALESCE(SUM(CASE WHEN cm.mes = 10 THEN cm.saldo_final ELSE 0 END), 0) AS outubro'),
                DB::raw('COALESCE(SUM(CASE WHEN cm.mes = 11 THEN cm.saldo_final ELSE 0 END), 0) AS novembro'),
                DB::raw('COALESCE(SUM(CASE WHEN cm.mes = 12 THEN cm.saldo_final ELSE 0 END), 0) AS dezembro')
            )
            ->whereIn('ii.id', $igrejasID)
            ->groupBy('ii.id', 'ii.nome', 'parent.nome')
            ->orderBy('ii.id');

        $result = $query->get();

        return $result;
    }

    private function handleListaIgrejas()
    {
        return DB::table('instituicoes_instituicoes as ii')
            ->join('instituicoes_tiposinstituicao as it', 'it.id', '=', 'ii.tipo_instituicao_id')
            ->select('ii.id', 'ii.nome as descricao')
            ->where('ii.instituicao_pai_id', '=', session()->get('session_perfil')->instituicao_id)
            ->where('ii.tipo_instituicao_id', '=', 1)
            ->where('ii.ativo', '=', 1)
            ->orderBy('ii.nome', 'ASC')
            ->get();
    }
}
