<?php

namespace App\Services\ServiceRegiaoRelatorios;

use App\Models\InstituicoesInstituicao;
use App\Models\InstituicoesTipoInstituicao;
use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LancamentoIgrejasService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute($dtano)
    {
        if (empty($dtano)) {
            $dtano = Carbon::now()->format('Y');
        } 

        $regiao = Identifiable::fetchtSessionRegiao();
        $lancamentos = $this->handleLancamentos($dtano, $regiao->id);

        return [
            'lancamentos' => $lancamentos,
            'regiao' => $regiao
        ];
    }

    private function handleLancamentos($dtano, $regiaoId)
    {
        $result = DB::table('instituicoes_instituicoes as ii')
            ->leftJoin('financeiro_lancamentos as fl', function($join) use ($dtano) {
                $join->on('ii.id', '=', 'fl.instituicao_id')
                     ->whereYear('fl.data_movimento', '=', $dtano);
            })
            ->leftJoin('instituicoes_instituicoes as parent', 'ii.instituicao_pai_id', '=', 'parent.id')
            ->select(
                'ii.nome as instituicao_nome',
                'parent.nome as instituicao_pai_nome',
                'ii.id',
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_movimento) = 1 THEN 1 END) AS janeiro'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_movimento) = 2 THEN 1 END) AS fevereiro'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_movimento) = 3 THEN 1 END) AS marco'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_movimento) = 4 THEN 1 END) AS abril'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_movimento) = 5 THEN 1 END) AS maio'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_movimento) = 6 THEN 1 END) AS junho'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_movimento) = 7 THEN 1 END) AS julho'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_movimento) = 8 THEN 1 END) AS agosto'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_movimento) = 9 THEN 1 END) AS setembro'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_movimento) = 10 THEN 1 END) AS outubro'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_movimento) = 11 THEN 1 END) AS novembro'),
                DB::raw('COUNT(CASE WHEN MONTH(fl.data_movimento) = 12 THEN 1 END) AS dezembro')
            )
            ->whereIn('parent.id', Identifiable::fetchDistritosIdByRegiao($regiaoId))
            ->where('fl.conciliado', 1)
            ->whereNull('ii.deleted_at')
            ->where('ii.ativo', 1)
            ->whereNull('fl.deleted_at')
            ->groupBy('ii.id', 'ii.nome', 'parent.nome')
            ->orderBy('parent.nome')
            ->orderBy('ii.nome')
            ->get();

        return $result;
    }


    private function handleListaIgrejasByRegiao($regiaoId)
    {
        $distritos = InstituicoesInstituicao::where('instituicao_pai_id', $regiaoId)
            ->get()
            ->unique('id')
            ->pluck('id')
            ->toArray();

        return DB::table('instituicoes_instituicoes as ii')
            ->join('instituicoes_tiposinstituicao as it', 'it.id', '=', 'ii.tipo_instituicao_id')
            ->select('ii.id', 'ii.nome as descricao')
            ->whereIn('ii.instituicao_pai_id', $distritos)
            ->where('ii.tipo_instituicao_id', InstituicoesTipoInstituicao::IGREJA_LOCAL)
            ->where('ii.ativo', 1)
            ->whereNull('ii.deleted_at')
            ->orderBy('ii.nome')
            ->get();
    }
}
