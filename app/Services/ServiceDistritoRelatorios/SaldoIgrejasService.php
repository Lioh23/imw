<?php

namespace App\Services\ServiceDistritoRelatorios;

use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SaldoIgrejasService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute($dt)
    {
        if (empty($dt)) {
            $dt = Carbon::now()->format('Y/m');
        }

        $lancamentos = $this->handleLancamentos($dt);

        return [
            'lancamentos' => $lancamentos
        ];
    }

    private function handleLancamentos($dt)
    {
        // Separar mês e ano da data no formato mm/yyyy
        $dateParts = explode('/', $dt);
        $mes = intval($dateParts[0]);
        $ano = intval($dateParts[1]);

        $instituicaoPaiId = session()->get('session_perfil')->instituicao_id;

        // Construir a consulta usando Query Builder
        $result = DB::select(
            DB::raw("
                SELECT 
                    ii.nome as instituicao_nome,
                    COALESCE(SUM(CASE WHEN fc.tipo = 'P' THEN fscm.saldo_final ELSE 0 END), 0) AS saldocxprincipal,
                    COALESCE(SUM(CASE WHEN fc.tipo = 'C' THEN fscm.saldo_final ELSE 0 END), 0) AS saldocxcongregacoes,
                    COALESCE(SUM(CASE WHEN fc.tipo = 'S' THEN fscm.saldo_final ELSE 0 END), 0) AS saldocxsecundado,
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
            ['ano' => $ano, 'mes' => $mes, 'instituicaoPaiId' => $instituicaoPaiId]
        );

        return $result;
    }
}
