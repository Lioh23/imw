<?php

namespace App\Services\ServiceDistritoRelatorios;

use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class QuantidadeMembrosService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute($dataInicial, $dataFinal, $tipo)
    {
        if (empty($dataInicial)) {
            $dataInicial = Carbon::now()->format('Y-m-d');
        }

        if (empty($dataFinal)) {
            $dataFinal = Carbon::now()->format('Y-m-d');
        }

        if (empty($tipo)) {
            $tipo = 'M';
        }

        $lancamentos = $this->handleLancamentos($dataInicial, $dataFinal, $tipo);

        return [
            'lancamentos' => $lancamentos
        ];
    }

    private function handleLancamentos($dataInicial, $dataFinal, $tipo)
    {
        $instituicaoPaiId = session()->get('session_perfil')->instituicao_id;  // Substitua conforme necessário

        $vinculoCondition = $tipo === 'C' ? ['C', 'M'] : ['M'];

        $results = DB::table('instituicoes_instituicoes as ii')
            ->select('ii.id', 'ii.nome')
            ->selectSub(function ($query) use ($dataFinal, $vinculoCondition) {
                $query->from('membresia_membros as mm')
                    ->join('membresia_rolpermanente as mr', 'mr.membro_id', '=', 'mm.id')
                    ->whereColumn('mr.distrito_id', 'ii.instituicao_pai_id')
                    ->where('mm.status', 'A')
                    ->whereIn('mm.vinculo', $vinculoCondition)
                    ->whereColumn('mr.igreja_id', 'ii.id')
                    ->where('mr.dt_recepcao', '<=', $dataFinal)
                    ->where(function ($query) use ($dataFinal) {
                        $query->where('mr.dt_exclusao', '<=', $dataFinal)
                            ->orWhereNull('mr.dt_exclusao');
                    })
                    ->selectRaw('COUNT(*)');
            }, 'total')
            ->where('ii.instituicao_pai_id', $instituicaoPaiId)
            ->orderBy('ii.nome')
            ->get();

        return $results;
    }
}
