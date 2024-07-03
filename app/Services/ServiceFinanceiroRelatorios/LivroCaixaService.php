<?php

namespace App\Services\ServiceFinanceiroRelatorios;

use App\Models\FinanceiroCaixa;
use App\Models\FinanceiroPlanoConta;
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
        $lancamentos = $this->handleLancamentos($dt, $caixaId);

        $essenciais = $this->handleEssenciais($dt);

        return [
            'caixas' => $caixas,
            'caixasSelect' => $caixasSelect,
            'lancamentos' => $lancamentos,
            'essenciais' => $essenciais
        ];
    }

    private function handleEssenciais($dt)
    {
        list($mes, $ano) = explode('/', $dt);
        $anoMes = $ano . '-' . str_pad($mes, 2, '0', STR_PAD_LEFT);

        $results = DB::table('financeiro_plano_contas as fpc')
        ->select('fpc.nome', 'fpc.numeracao')
        ->where('essencial', 1)
        ->whereNotIn('fpc.id', function ($query) use ($anoMes) {
            $query->select('fl.plano_conta_id')
                ->from('financeiro_lancamentos as fl')
                ->where('fl.instituicao_id', session()->get('session_perfil')->instituicao_id)
                ->whereRaw('DATE_FORMAT(fl.data_movimento, "%Y-%m") = ?', [$anoMes]);
        })
        ->get();
        


        return $results;
    }

    private function handleListaCaixas()
    {
        return FinanceiroCaixa::where('instituicao_id', session()->get('session_perfil')->instituicao_id)
            ->orderBy('id', 'asc')
            ->get();
    }

    private function handleLancamentos($dt, $caixaID)
    {
        $sql = "SELECT 
                    fpc.numeracao,
                    MAX(fpc.nome) AS nome,
                    fc.descricao AS caixa,
                    SUM(fl.valor) AS total
                FROM 
                    financeiro_lancamentos fl
                JOIN 
                    financeiro_plano_contas fpc ON fpc.id = fl.plano_conta_id
                JOIN 
                    financeiro_caixas fc ON fc.id = fl.caixa_id
                WHERE 
                    fl.instituicao_id = :instituicaoID  ";

        if ($caixaID !== 'all') {
            $sql .= "AND fl.caixa_id = :caixaId ";
        }

        $sql .= "AND fl.deleted_at IS NULL 
                AND DATE_FORMAT(fl.data_movimento, '%m/%Y') = :dt 
                GROUP BY 
                    fc.descricao,
                    CAST(SUBSTRING_INDEX(fpc.numeracao, '.', 1) AS UNSIGNED),  
                    CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(fpc.numeracao, '.', 2), '.', -1) AS UNSIGNED),   
                    CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(fpc.numeracao, '.', 3), '.', -1) AS UNSIGNED),  
                    fpc.numeracao   
                ORDER BY 
                    CAST(SUBSTRING_INDEX(fpc.numeracao, '.', 1) AS UNSIGNED),
                    CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(fpc.numeracao, '.', 2), '.', -1) AS UNSIGNED),
                    CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(fpc.numeracao, '.', 3), '.', -1) AS UNSIGNED),
                    fpc.numeracao ";

        $params = [
            'dt' => $dt,
            'instituicaoID' => session()->get('session_perfil')->instituicao_id,
        ];

        if ($caixaID !== 'all') {
            $params['caixaId'] = $caixaID;
        }

        $lancamentos = DB::select($sql, $params);

        return $lancamentos;
    }


    private function handleCaixas($dt, $caixaId)
    {
        // Dividindo a data em mês e ano
        list($mes, $ano) = explode('/', $dt);
        $anoMes = $ano . str_pad($mes, 2, '0', STR_PAD_LEFT);
        $instituicaoID = session()->get('session_perfil')->instituicao_id;
  
        // Construção da query com as variáveis diretamente
        $sql = "SELECT 
    fc.descricao AS caixa, fc.id,
    COALESCE(MAX(fscm_max.saldo_final), 0.00) AS saldo_final,
    COALESCE(SUM(CASE WHEN fl.plano_conta_id NOT IN (100002, 100003, 110095, 110096, 110097, 110098, 110120, 110121, 110128, 110137) AND fl.tipo_lancamento = 'E' THEN fl.valor ELSE 0 END), 0) AS total_entradas,
    COALESCE(SUM(CASE WHEN fl.plano_conta_id NOT IN (100002, 100003, 110095, 110096, 110097, 110098, 110120, 110121, 110128, 110137) AND fl.tipo_lancamento = 'S' THEN fl.valor ELSE 0 END), 0) AS total_saidas,
    COALESCE(SUM(CASE WHEN fl.plano_conta_id IN (100002, 100003, 110095, 110096, 110097, 110098, 110120, 110121, 110128, 110137) AND fl.tipo_lancamento = 'E' THEN fl.valor ELSE 0 END), 0) AS total_transferencias_entrada,
    COALESCE(SUM(CASE WHEN fl.plano_conta_id IN (100002, 100003, 110095, 110096, 110097, 110098, 110120, 110121, 110128, 110137) AND fl.tipo_lancamento = 'S' THEN fl.valor ELSE 0 END), 0) AS total_transferencias_saida,
    COALESCE((
        (MAX(fscm_max.saldo_final) +  
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
    financeiro_lancamentos fl ON fc.id = fl.caixa_id AND DATE_FORMAT(fl.data_movimento, '%m/%Y') = '$dt' AND fl.deleted_at IS NULL
LEFT JOIN 
 (
 SELECT 
        fscm_interno.caixa_id,
        fscm_interno.saldo_final
    FROM 
        financeiro_saldo_consolidado_mensal fscm_interno
    WHERE 
        fscm_interno.instituicao_id = '$instituicaoID'
        AND (fscm_interno.ano = (SELECT MAX(ano) FROM financeiro_saldo_consolidado_mensal 
                                 WHERE instituicao_id = '$instituicaoID') )
		AND (fscm_interno.mes = (SELECT MAX(mes) FROM financeiro_saldo_consolidado_mensal 
		                        WHERE ano = (SELECT MAX(ano) FROM financeiro_saldo_consolidado_mensal WHERE instituicao_id = '$instituicaoID')
		                        and instituicao_id = '$instituicaoID')))
		                       fscm_max on fc.id=fscm_max.caixa_id
WHERE 
    fc.instituicao_id = '$instituicaoID'
    AND fc.deleted_at IS NULL ";
        
        // Condição para selecionar apenas um caixa específico, se o caixaId não for 'all'
        if ($caixaId !== 'all') {
            $sql .= "AND fc.id = '$caixaId' ";
        }
        
        $sql .= "GROUP BY 
                fc.id,
                fc.descricao
            ORDER BY 
                fc.id"; 
    
        try {
            $caixas = DB::select($sql);
        } catch (\Exception $e) {
            throw $e;
        }
    
        return $caixas;
    }
    
    
    
}
