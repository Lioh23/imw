<?php

namespace App\Services\ServiceFinanceiroRelatorios;

use App\Models\FinanceiroCaixa;
use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BalanceteService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute($dataInicial, $dataFinal, $caixaId)
    {


        if (empty($dataInicial)) {
            $dataInicial = Carbon::now()->format('m/Y');
        }

        if (empty($dataFinal)) {
            $dataFinal = Carbon::now()->format('m/Y');
        }

        $caixasSelect  = $this->handleListaCaixas();

        $caixas =  $this->handleCaixas($dataInicial, $dataFinal, $caixaId);
        $lancamentos = $this->handleLancamentos($dataInicial, $dataFinal, $caixaId);

        return [
            'caixas' => $caixas,
            'caixasSelect' => $caixasSelect,
            'lancamentos' => $lancamentos
        ];
    }


    private function handleListaCaixas()
    {
        return FinanceiroCaixa::where('instituicao_id', session()->get('session_perfil')->instituicao_id)
            ->orderBy('id', 'asc')
            ->get();
    }


    private function handleLancamentos($dt_inicial, $dt_final, $caixaID)
    {
        // Usando Carbon para manipulação de datas
        $dataInicial = Carbon::createFromFormat('m/Y', $dt_inicial)->startOfMonth()->format('Y-m-d');
        $dataFinal = Carbon::createFromFormat('m/Y', $dt_final)->endOfMonth()->format('Y-m-d');

        $instituicaoID = session()->get('session_perfil')->instituicao_id;

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
                    fl.instituicao_id = '$instituicaoID' ";

        if ($caixaID !== 'all') {
            $sql .= "AND fc.id = '$caixaID' ";
        }
        $sql .= "AND fl.deleted_at IS NULL 
                AND fl.data_movimento BETWEEN '$dataInicial' AND '$dataFinal'
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
                    fpc.numeracao";

        try {
            $lancamentos = DB::select($sql);
        } catch (\Exception $e) {
            throw $e;
        }

        return $lancamentos;
    }


    private function handleCaixas($dt_inicial, $dt_final, $caixaId)
    {
        // Usando Carbon para manipulação de datas
        $dataInicial = Carbon::createFromFormat('m/Y', $dt_inicial)->startOfMonth()->format('Y-m-d');
        $dataFinal = Carbon::createFromFormat('m/Y', $dt_final)->endOfMonth()->format('Y-m-d');

        $instituicaoID = session()->get('session_perfil')->instituicao_id;

        // Calculando o mês anterior usando Carbon
        $dataMesAnterior = Carbon::createFromFormat('m/Y', $dt_inicial)->subMonth();
        $mesAnterior = $dataMesAnterior->format('m');
        $anoAnterior = $dataMesAnterior->format('Y');

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
            financeiro_lancamentos fl ON fc.id = fl.caixa_id AND fl.deleted_at IS NULL 
            AND fl.data_movimento BETWEEN '$dataInicial' AND '$dataFinal'
        LEFT JOIN 
        (
        SELECT 
                fscm_interno.caixa_id,
                fscm_interno.saldo_final
            FROM 
                financeiro_saldo_consolidado_mensal fscm_interno
            WHERE 
                fscm_interno.instituicao_id = '$instituicaoID'
                AND fscm_interno.ano = '$anoAnterior'
                AND fscm_interno.mes = '$mesAnterior'
        ) fscm_max on fc.id=fscm_max.caixa_id
        WHERE 
            fc.instituicao_id = '$instituicaoID'
            AND fc.deleted_at IS NULL ";

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
