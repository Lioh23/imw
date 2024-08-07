<?php

namespace App\Services\ServiceDistritoRelatorios;

use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EstatisticaGeneroService
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
        $instituicaoPaiId = session()->get('session_perfil')->instituicao_id;

        $vinculoCondition = $tipo === 'C' ? ['C', 'M'] : ['M'];

        /*  $results = DB::table('instituicoes_instituicoes as ii')
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
                        ->where('mm.sexo', 'M')
                        ->selectRaw('COUNT(*)');
                }, 'total_masculino')
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
                        ->where('mm.sexo', 'F')
                        ->selectRaw('COUNT(*)');
                }, 'total_feminino')
                ->where('ii.instituicao_pai_id', $instituicaoPaiId)
                ->orderBy('ii.nome')
                ->get(); */

        $results = DB::table('instituicoes_instituicoes as ii')
            ->select('ii.id', 'ii.nome')
            // Total de membros até dataInicial (total_x)
            ->selectSub(function ($query) use ($dataInicial, $vinculoCondition) {
                $query->from('membresia_membros as mm')
                    ->join('membresia_rolpermanente as mr', 'mr.membro_id', '=', 'mm.id')
                    ->whereColumn('mr.distrito_id', 'ii.instituicao_pai_id')
                    ->where('mm.status', 'A')
                    ->whereIn('mm.vinculo', $vinculoCondition)
                    ->whereColumn('mr.igreja_id', 'ii.id')
                    ->where('mr.dt_recepcao', '<=', $dataInicial)
                    ->where(function ($query) use ($dataInicial) {
                        $query->where('mr.dt_exclusao', '<=', $dataInicial)
                            ->orWhereNull('mr.dt_exclusao');
                    })
                    ->selectRaw('COUNT(*)');
            }, 'total_x')
            // Total de membros até dataFinal (total_y)
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
            }, 'total_y')
            // Total de membros masculinos até dataInicial (total_masculino_x)
            ->selectSub(function ($query) use ($dataInicial, $vinculoCondition) {
                $query->from('membresia_membros as mm')
                    ->join('membresia_rolpermanente as mr', 'mr.membro_id', '=', 'mm.id')
                    ->whereColumn('mr.distrito_id', 'ii.instituicao_pai_id')
                    ->where('mm.status', 'A')
                    ->whereIn('mm.vinculo', $vinculoCondition)
                    ->whereColumn('mr.igreja_id', 'ii.id')
                    ->where('mr.dt_recepcao', '<=', $dataInicial)
                    ->where(function ($query) use ($dataInicial) {
                        $query->where('mr.dt_exclusao', '<=', $dataInicial)
                            ->orWhereNull('mr.dt_exclusao');
                    })
                    ->where('mm.sexo', 'M')
                    ->selectRaw('COUNT(*)');
            }, 'total_masculino_x')
            // Total de membros masculinos até dataFinal (total_masculino_y)
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
                    ->where('mm.sexo', 'M')
                    ->selectRaw('COUNT(*)');
            }, 'total_masculino_y')
            // Total de membros femininos até dataInicial (total_feminino_x)
            ->selectSub(function ($query) use ($dataInicial, $vinculoCondition) {
                $query->from('membresia_membros as mm')
                    ->join('membresia_rolpermanente as mr', 'mr.membro_id', '=', 'mm.id')
                    ->whereColumn('mr.distrito_id', 'ii.instituicao_pai_id')
                    ->where('mm.status', 'A')
                    ->whereIn('mm.vinculo', $vinculoCondition)
                    ->whereColumn('mr.igreja_id', 'ii.id')
                    ->where('mr.dt_recepcao', '<=', $dataInicial)
                    ->where(function ($query) use ($dataInicial) {
                        $query->where('mr.dt_exclusao', '<=', $dataInicial)
                            ->orWhereNull('mr.dt_exclusao');
                    })
                    ->where('mm.sexo', 'F')
                    ->selectRaw('COUNT(*)');
            }, 'total_feminino_x')
            // Total de membros femininos até dataFinal (total_feminino_y)
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
                    ->where('mm.sexo', 'F')
                    ->selectRaw('COUNT(*)');
            }, 'total_feminino_y')
            ->where('ii.instituicao_pai_id', $instituicaoPaiId)
            ->orderBy('ii.nome')
            ->get();
            
        return $results;
    }
}
