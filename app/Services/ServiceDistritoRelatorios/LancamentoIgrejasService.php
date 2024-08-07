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
        $result = DB::table('instituicoes_instituicoes as ii')
            ->leftJoin('financeiro_lancamentos as fl', function($join) use ($dtano) {
                $join->on('ii.id', '=', 'fl.instituicao_id')
                     ->whereYear('fl.data_lancamento', '=', $dtano);
            })
            ->leftJoin('instituicoes_instituicoes as parent', 'ii.instituicao_pai_id', '=', 'parent.id')
            ->select(
                'ii.nome as instituicao_nome',
                'parent.nome as instituicao_pai_nome',
                'ii.id',
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_lancamento) = 1 THEN 1 END) AS janeiro'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_lancamento) = 2 THEN 1 END) AS fevereiro'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_lancamento) = 3 THEN 1 END) AS marco'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_lancamento) = 4 THEN 1 END) AS abril'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_lancamento) = 5 THEN 1 END) AS maio'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_lancamento) = 6 THEN 1 END) AS junho'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_lancamento) = 7 THEN 1 END) AS julho'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_lancamento) = 8 THEN 1 END) AS agosto'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_lancamento) = 9 THEN 1 END) AS setembro'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_lancamento) = 10 THEN 1 END) AS outubro'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_lancamento) = 11 THEN 1 END) AS novembro'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_lancamento) = 12 THEN 1 END) AS dezembro')
            )
            ->whereIn('ii.id', $igrejasID)
            ->groupBy('ii.id', 'ii.nome', 'parent.nome')
            ->orderBy('ii.id')
            ->get();

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
