<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait LivroRazaoGeralUtils
{
    public static function fetch($dataInicial, $dataFinal, $distritoId): array
    {
        $result = DB::select("
            SELECT 
                DATE_FORMAT(fl.data_movimento, '%d/%m/%Y') AS data_movimentacao,
                ii.nome AS instituicao_nome,
                pc.numeracao,
                pc.nome AS plano_conta_nome,
                COALESCE(SUM(CASE WHEN fl.tipo_lancamento = 'E' THEN fl.valor ELSE 0 END), 0) AS total_entradas,
                COALESCE(SUM(CASE WHEN fl.tipo_lancamento = 'S' THEN fl.valor ELSE 0 END), 0) AS total_saidas,
                COALESCE(SUM(CASE WHEN fl.tipo_lancamento = 'E' THEN fl.valor ELSE 0 END) - SUM(CASE WHEN fl.tipo_lancamento = 'S' THEN fl.valor ELSE 0 END), 0) AS total
            FROM 
                instituicoes_instituicoes ii
            LEFT JOIN 
                financeiro_lancamentos fl ON ii.id = fl.instituicao_id 
                AND fl.data_movimento BETWEEN :dataInicial AND :dataFinal
            LEFT JOIN 
                financeiro_plano_contas pc ON fl.plano_conta_id = pc.id
            WHERE 
                ii.tipo_instituicao_id = 1
                AND ii.instituicao_pai_id = :instituicaoPaiId
            GROUP BY 
                fl.data_movimento,
                ii.nome,
                pc.numeracao, 
                pc.nome
            HAVING
                total_entradas > 0 OR total_saidas > 0 OR total > 0
            ORDER BY 
                pc.numeracao ASC,
                fl.data_movimento ASC
        ",
        ['dataInicial' => $dataInicial, 'dataFinal' => $dataFinal, 'instituicaoPaiId' => $distritoId]);
    
        $grouped = [];
        foreach ($result as $item) {
            $key = $item->numeracao . ' - ' . $item->plano_conta_nome;
            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'total_entradas' => 0,
                    'total_saidas' => 0,
                    'total' => 0,
                    'movimentos' => []
                ];
            }
            $grouped[$key]['total_entradas'] += $item->total_entradas;
            $grouped[$key]['total_saidas'] += $item->total_saidas;
            $grouped[$key]['total'] = $grouped[$key]['total_entradas'] - $grouped[$key]['total_saidas'];
            $grouped[$key]['movimentos'][] = $item;
        }
    
        return $grouped;
    }
}