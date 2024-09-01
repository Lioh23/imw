<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait SaldoIgrejasUtils
{
    public static function fetch($dt, $distritoId): array
    {
        {
            // Separar mês e ano da data no formato mm/yyyy
            $dateParts = explode('/', $dt);
            $mes = intval($dateParts[0]);
            $ano = intval($dateParts[1]);
        
            // Construir a consulta usando Query Builder
            $result = DB::select(
                DB::raw("
                    SELECT 
                        ii.nome as instituicao_nome,
                        COALESCE(SUM(CASE WHEN fc.tipo = 'P' THEN fscm.saldo_final ELSE 0 END), 0) AS saldocxprincipal,
                        COALESCE(SUM(CASE WHEN fc.tipo = 'C' THEN fscm.saldo_final ELSE 0 END), 0) AS saldocxcongregacoes,
                        COALESCE(SUM(CASE WHEN fc.tipo = 'S' THEN fscm.saldo_final ELSE 0 END), 0) AS saldocxsecundado,
                        COALESCE(SUM(CASE WHEN fc.tipo = 'B' THEN fscm.saldo_final ELSE 0 END), 0) AS saldocxbancos,
                        COALESCE(SUM(CASE WHEN fc.tipo = 'D' THEN fscm.saldo_final ELSE 0 END), 0) AS saldocxoutros,
                        COALESCE(SUM(fscm.saldo_final), 0) AS total
                    FROM 
                        instituicoes_instituicoes ii
                    LEFT JOIN 
                        financeiro_saldo_consolidado_mensal fscm ON ii.id = fscm.instituicao_id 
                        AND fscm.ano = :ano AND fscm.mes = :mes
                    LEFT JOIN 
                        financeiro_caixas fc ON fscm.caixa_id = fc.id
                    WHERE 
                        ii.tipo_instituicao_id = 1 AND 
                        ii.instituicao_pai_id = :instituicaoPaiId
                    GROUP BY 
                        ii.nome
                    ORDER BY 
                        ii.nome ASC
                "),
                ['ano' => $ano, 'mes' => $mes, 'instituicaoPaiId' => $distritoId]
            );
    
            return $result;
        }
    }
}
