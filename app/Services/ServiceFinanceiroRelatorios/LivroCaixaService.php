<?php

namespace App\Services\ServiceFinanceiroRelatorios;

use App\Models\FinanceiroCaixa;
use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LivroCaixaService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute($dt, $caixaId)
    {
        if (empty($dt)) {
            $dt = Carbon::now()->format('Y/m');
        }
   
        $caixasSelect  = $this->handleListaCaixas();

        $caixas =  $this->handleCaixas($dt, $caixaId);

        return [
            'caixas' => $caixas,
            'caixasSelect' => $caixasSelect
        ];
    }


    private function handleListaCaixas()
    {
        return FinanceiroCaixa::where('instituicao_id', session()->get('session_perfil')->instituicao_id)
            ->orderBy('id', 'asc')
            ->get();
    }

    private function handleCaixas($dt, $caixaId)
    {
        // Dividindo a data em mês e ano
        list($mes, $ano) = explode('/', $dt);
        $anoMes = $ano . str_pad($mes, 2, '0', STR_PAD_LEFT);

        $sql = "SELECT 
            fc.descricao AS caixa,
            MAX(COALESCE(fscm.saldo_final, 0.00)) AS saldo_final,
            COALESCE(SUM(CASE WHEN fl.plano_conta_id NOT IN (100002, 100003, 110095, 110096, 110097, 110098, 110120, 110121, 110128, 110137) AND fl.tipo_lancamento = 'E' THEN fl.valor ELSE 0 END), 0) AS total_entradas,
            COALESCE(SUM(CASE WHEN fl.plano_conta_id NOT IN (100002, 100003, 110095, 110096, 110097, 110098, 110120, 110121, 110128, 110137) AND fl.tipo_lancamento = 'S' THEN fl.valor ELSE 0 END), 0) AS total_saidas,
            COALESCE(SUM(CASE WHEN fl.plano_conta_id IN (100002, 100003, 110095, 110096, 110097, 110098, 110120, 110121, 110128, 110137) AND fl.tipo_lancamento = 'E' THEN fl.valor ELSE 0 END), 0) AS total_transferencias_entrada,
            COALESCE(SUM(CASE WHEN fl.plano_conta_id IN (100002, 100003, 110095, 110096, 110097, 110098, 110120, 110121, 110128, 110137) AND fl.tipo_lancamento = 'S' THEN fl.valor ELSE 0 END), 0) AS total_transferencias_saida,
            COALESCE((
                (MAX(fscm.saldo_final) +  
                COALESCE(SUM(CASE WHEN fl.plano_conta_id NOT IN (100002, 100003, 110095, 110096, 110097, 110098, 110120, 110121, 110128, 110137) AND fl.tipo_lancamento = 'E' THEN fl.valor ELSE 0 END), 0) +
                COALESCE(SUM(CASE WHEN fl.plano_conta_id IN (100002, 100003, 110095, 110096, 110097, 110098, 110120, 110121, 110128, 110137) AND fl.tipo_lancamento = 'E' THEN fl.valor ELSE 0 END), 0)
                ) -
                (
                COALESCE(SUM(CASE WHEN fl.plano_conta_id NOT IN (100002, 100003, 110095, 110096, 110097, 110098, 110120, 110121, 110128, 110137) AND fl.tipo_lancamento = 'S' THEN fl.valor ELSE 0 END), 0) +
                COALESCE(SUM(CASE WHEN fl.plano_conta_id IN (100002, 100003, 110095, 110096, 110097, 110098, 110120, 110121, 110128, 110137) AND fl.tipo_lancamento = 'S' THEN fl.valor ELSE 0 END), 0)
                )
            ), 0) AS saldo_atual
        FROM 
            financeiro_caixas fc
        LEFT JOIN 
            financeiro_lancamentos fl ON fc.id = fl.caixa_id AND 
            DATE_FORMAT(fl.data_movimento, '%m/%Y') = :dt 
        LEFT JOIN 
            (SELECT caixa_id, MAX(saldo_final) AS saldo_final
            FROM financeiro_saldo_consolidado_mensal
            WHERE ano * 100 + mes < :ano_mes
            GROUP BY caixa_id) fscm ON fc.id = fscm.caixa_id
        WHERE 
            fc.instituicao_id = :instituicaoID
            AND fc.deleted_at IS NULL
            AND fl.deleted_at IS NULL ";

        // Condição para selecionar apenas um caixa específico, se o caixaId não for 99
        if ($caixaId !== 'all') {
            $sql .= "AND fc.id = :caixaId ";
        }

        $sql .= "GROUP BY 
        fc.id, fc.descricao;";


        $params = [
            'ano_mes' => $anoMes,
            'dt' => $dt,
            'instituicaoID' => session()->get('session_perfil')->instituicao_id,
        ];

        if ($caixaId !== 'all') {
            $params['caixaId'] = $caixaId;
        }

        $caixas = DB::select($sql, $params);

        return $caixas;
    }
}
