<?php

namespace App\Services\ServiceIgrejas;

use App\Models\InstituicoesInstituicao;
use Illuminate\Support\Facades\DB;

class GetEstatisticaAnoEclesiasticoService
{
    public function execute(InstituicoesInstituicao $igreja, $ano = null)
    {
        $ano ??= date('Y');

        return [
            'igreja'           => $igreja,
            'ano'              => $ano,
            'membrosRecebidos' => $this->handleEstatisticaRecepcao($igreja->id, $ano),
            'membrosExcluidos' => $this->handleEstatisticaExclusao($igreja->id, $ano),
            'rolAtual'         => $this->handleTotalRolAtual($igreja->id)
        ];
    }

    private function handleEstatisticaRecepcao($igrejaId, $ano)
    {
        $query = "SELECT 
            descricao,
            
            (	SELECT count(*) 
                FROM membresia_rolpermanente mr, membresia_membros mm 
                WHERE mr.membro_id = mm.id
                AND mr.modo_recepcao_id = ms.id
                AND year(dt_recepcao) = $ano
                AND mr.igreja_id = $igrejaId
                AND mm.sexo = 'M'	) sexo_masculino,
                
            (	SELECT count(*) 
                FROM membresia_rolpermanente mr, membresia_membros mm 
                WHERE mr.membro_id = mm.id
                AND mr.modo_recepcao_id = ms.id
                AND year(dt_recepcao) = $ano
                AND mr.igreja_id = $igrejaId
                AND mm.sexo = 'F') sexo_feminino,
                
            (	SELECT count(*) 
                FROM membresia_rolpermanente mr, membresia_membros mm 
                WHERE mr.membro_id = mm.id
                AND year(dt_recepcao) = $ano
                AND mr.igreja_id = $igrejaId
                AND mr.modo_recepcao_id = ms.id
            ) total
            
         FROM membresia_situacoes ms
        WHERE ms.tipo  = 'R'
          AND deleted_at IS NULL";

        return collect(DB::select($query));
    }

    private function handleEstatisticaExclusao($igrejaId, $ano)
    {
        $query = "SELECT 
            descricao,
            
            (	SELECT count(*) 
                FROM membresia_rolpermanente mr, membresia_membros mm 
                WHERE mr.membro_id = mm.id
                AND mr.modo_exclusao_id = ms.id
                AND year(mr.dt_exclusao) = $ano
                AND mr.igreja_id = $igrejaId
                AND mm.sexo = 'M'	) sexo_masculino,
                
            (	SELECT count(*) 
                FROM membresia_rolpermanente mr, membresia_membros mm 
                WHERE mr.membro_id = mm.id
                AND mr.modo_exclusao_id = ms.id
                AND year(mr.dt_exclusao) = $ano
                AND mr.igreja_id = $igrejaId
                AND mm.sexo = 'F') sexo_feminino,
                
            (	SELECT count(*) 
                FROM membresia_rolpermanente mr, membresia_membros mm 
                WHERE mr.membro_id = mm.id
                AND year(mr.dt_exclusao) = $ano
                AND mr.igreja_id = $igrejaId
                AND mr.modo_exclusao_id = ms.id
            ) total
            
         FROM membresia_situacoes ms
        WHERE ms.tipo  = 'E'
          AND deleted_at IS NULL";

        return collect(DB::select($query));
    }

    private function handleTotalRolatual($igrejaId)
    {
        $query = "SELECT 
            (	SELECT count(*)
                FROM membresia_rolpermanente mr, membresia_membros mm 
                WHERE mm.id = mr.membro_id 
                AND mr.lastrec = 1	
                AND mr.dt_exclusao IS NULL
                AND mr.igreja_id = $igrejaId
                AND mm.sexo = 'M' ) sexo_masculino,
                
            (	SELECT count(*)
                FROM membresia_rolpermanente mr, membresia_membros mm 
                WHERE mm.id = mr.membro_id 
                AND mr.lastrec = 1	
                AND mr.dt_exclusao IS NULL
                AND mr.igreja_id = $igrejaId
                AND mm.sexo = 'F' ) sexo_feminino,
                
            (	SELECT count(*)
                FROM membresia_rolpermanente mr, membresia_membros mm 
                WHERE mm.id = mr.membro_id 
                AND mr.lastrec = 1	
                AND mr.dt_exclusao IS NULL
                AND mr.igreja_id = $igrejaId	) total";

        return DB::selectOne($query);
    }
}