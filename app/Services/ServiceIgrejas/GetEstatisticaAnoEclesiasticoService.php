<?php

namespace App\Services\ServiceIgrejas;

use App\Models\InstituicoesInstituicao;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GetEstatisticaAnoEclesiasticoService
{
    public function execute(InstituicoesInstituicao $igreja, $ano = null)
    {
        $dataReferenciaRolAtual = $this->handleDataReferenciaRolAtual($ano ?? date('Y'));
        [$dataInicialRolAnterior, $dataFinalRolAnterior] = $this->handlePeriodoRolAnterior($dataReferenciaRolAtual);

        return [
            'igreja'           => $igreja,
            'ano'              => $ano,
            'membrosRecebidos' => $this->handleEstatisticaRecepcao($igreja->id, $dataReferenciaRolAtual),
            'membrosExcluidos' => $this->handleEstatisticaExclusao($igreja->id, $dataReferenciaRolAtual),
            'rolAtual'         => $this->handleTotalRolAtual($igreja->id, $dataReferenciaRolAtual),
            'rolAnterior'      => $this->handleTotalRolAnterior($igreja->id, $dataInicialRolAnterior, $dataFinalRolAnterior)
        ];
    }

    private function handleDataReferenciaRolAtual($ano): string
    {
        $dataHoje = Carbon::today()->startOfDay();
        $dataReferencia = Carbon::parse("$ano-11-01")->startOfDay();

        return $dataHoje->lessThan($dataReferencia)
            ? sprintf('%s-11-01', $ano - 1)
            : sprintf('%s-11-01', $ano);
    }

    private function handlePeriodoRolAnterior(string $dataReferenciaRolAtual): array
    {
        $periodoInicial = Carbon::parse($dataReferenciaRolAtual)->subYear()->startOfDay();
        $periodoFinal = Carbon::parse($dataReferenciaRolAtual)->subDay()->startOfDay();

        return [
            $periodoInicial->format('Y-m-d'),
            $periodoFinal->format('Y-m-d'),
        ];
    }

    private function handleEstatisticaRecepcao($igrejaId, $dataReferencia)
    {
        $query = "SELECT 
            descricao,
            
            (	SELECT count(*) 
                FROM membresia_rolpermanente mr, membresia_membros mm 
                WHERE mr.membro_id = mm.id
                AND mr.modo_recepcao_id = ms.id
                AND dt_recepcao >= '$dataReferencia'
                AND mr.igreja_id = $igrejaId
                AND mm.sexo = 'M'	) sexo_masculino,
                
            (	SELECT count(*) 
                FROM membresia_rolpermanente mr, membresia_membros mm 
                WHERE mr.membro_id = mm.id
                AND mr.modo_recepcao_id = ms.id
                AND dt_recepcao >= '$dataReferencia'
                AND mr.igreja_id = $igrejaId
                AND mm.sexo = 'F') sexo_feminino,
                
            (	SELECT count(*) 
                FROM membresia_rolpermanente mr, membresia_membros mm 
                WHERE mr.membro_id = mm.id
                AND dt_recepcao >= '$dataReferencia'
                AND mr.igreja_id = $igrejaId
                AND mr.modo_recepcao_id = ms.id
            ) total
            
         FROM membresia_situacoes ms
        WHERE ms.tipo  = 'R'
          AND deleted_at IS NULL";

        return collect(DB::select($query));
    }

    private function handleEstatisticaExclusao($igrejaId, $dataReferencia)
    {
        $query = "SELECT 
            descricao,
            
            (	SELECT count(*) 
                FROM membresia_rolpermanente mr, membresia_membros mm 
                WHERE mr.membro_id = mm.id
                AND mr.modo_exclusao_id = ms.id
                AND mr.dt_exclusao >= '$dataReferencia'
                AND mr.igreja_id = $igrejaId
                AND mm.sexo = 'M'	) sexo_masculino,
                
            (	SELECT count(*) 
                FROM membresia_rolpermanente mr, membresia_membros mm 
                WHERE mr.membro_id = mm.id
                AND mr.modo_exclusao_id = ms.id
                AND mr.dt_exclusao >= '$dataReferencia'
                AND mr.igreja_id = $igrejaId
                AND mm.sexo = 'F') sexo_feminino,
                
            (	SELECT count(*) 
                FROM membresia_rolpermanente mr, membresia_membros mm 
                WHERE mr.membro_id = mm.id
                AND mr.dt_exclusao >= '$dataReferencia'
                AND mr.igreja_id = $igrejaId
                AND mr.modo_exclusao_id = ms.id
            ) total
            
         FROM membresia_situacoes ms
        WHERE ms.tipo  = 'E'
          AND deleted_at IS NULL";

        return collect(DB::select($query));
    }

    private function handleTotalRolatual($igrejaId, $dataReferencia)
    {
        $query = "SELECT 
            (	
                (
                    SELECT count(*)
                    FROM membresia_rolpermanente mr, membresia_membros mm 
                    WHERE mm.id = mr.membro_id 
                    AND mr.dt_recepcao >= '$dataReferencia'
                    AND mr.igreja_id = $igrejaId
                    AND mm.sexo = 'M' 
                ) -
                (
                    SELECT count(*)
                    FROM membresia_rolpermanente mr, membresia_membros mm 
                    WHERE mm.id = mr.membro_id 
                    AND mr.dt_exclusao >= '$dataReferencia'
                    AND mr.igreja_id = $igrejaId
                    AND mm.sexo = 'M' 
                )
            ) sexo_masculino,  
            (	
                (
                    SELECT count(*)
                    FROM membresia_rolpermanente mr, membresia_membros mm 
                    WHERE mm.id = mr.membro_id 
                    AND mr.dt_recepcao >= '$dataReferencia'
                    AND mr.igreja_id = $igrejaId
                    AND mm.sexo = 'F' 
                ) -
                (
                    SELECT count(*)
                    FROM membresia_rolpermanente mr, membresia_membros mm 
                    WHERE mm.id = mr.membro_id 
                    AND mr.dt_exclusao >= '$dataReferencia'
                    AND mr.igreja_id = $igrejaId
                    AND mm.sexo = 'F' 
                )
            ) sexo_feminino,
            (
                (
                    SELECT count(*)
                    FROM membresia_rolpermanente mr, membresia_membros mm 
                    WHERE mm.id = mr.membro_id 
                    AND mr.dt_recepcao >= '$dataReferencia'
                    AND mr.igreja_id = $igrejaId
                ) -
                (
                    SELECT count(*)
                    FROM membresia_rolpermanente mr, membresia_membros mm 
                    WHERE mm.id = mr.membro_id 
                    AND mr.dt_exclusao >= '$dataReferencia'
                    AND mr.igreja_id = $igrejaId
                )	
                
            ) total";

        return DB::selectOne($query);
    }

    private function handleTotalRolAnterior($igrejaId, $dataInicial, $dataFinal)
    {
        $query = "SELECT 
            (	
                (
                    SELECT count(*)
                    FROM membresia_rolpermanente mr, membresia_membros mm 
                    WHERE mm.id = mr.membro_id 
                    AND mr.dt_recepcao BETWEEN $dataInicial AND $dataFinal
                    AND mr.igreja_id = $igrejaId
                    AND mm.sexo = 'M' 
                ) -
                (
                    SELECT count(*)
                    FROM membresia_rolpermanente mr, membresia_membros mm 
                    WHERE mm.id = mr.membro_id 
                    AND mr.dt_exclusao BETWEEN $dataInicial AND $dataFinal	
                    AND mr.igreja_id = $igrejaId
                    AND mm.sexo = 'M' 
                )
            ) sexo_masculino,  
            (	
                (
                    SELECT count(*)
                    FROM membresia_rolpermanente mr, membresia_membros mm 
                    WHERE mm.id = mr.membro_id 
                    AND mr.dt_recepcao BETWEEN $dataInicial AND $dataFinal
                    AND mr.igreja_id = $igrejaId
                    AND mm.sexo = 'F' 
                ) -
                (
                    SELECT count(*)
                    FROM membresia_rolpermanente mr, membresia_membros mm 
                    WHERE mm.id = mr.membro_id 
                    AND mr.dt_exclusao BETWEEN $dataInicial AND $dataFinal	
                    AND mr.igreja_id = $igrejaId
                    AND mm.sexo = 'F' 
                )
            ) sexo_feminino,
            (
                (
                    SELECT count(*)
                    FROM membresia_rolpermanente mr, membresia_membros mm 
                    WHERE mm.id = mr.membro_id 
                    AND mr.dt_recepcao BETWEEN $dataInicial AND $dataFinal
                    AND mr.igreja_id = $igrejaId
                ) -
                (
                    SELECT count(*)
                    FROM membresia_rolpermanente mr, membresia_membros mm 
                    WHERE mm.id = mr.membro_id 
                    AND mr.dt_exclusao BETWEEN $dataInicial AND $dataFinal	
                    AND mr.igreja_id = $igrejaId
                )	
                
            ) total";

        return DB::selectOne($query);
    }
}