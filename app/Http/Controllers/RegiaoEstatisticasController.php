<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegiaoEstatisticasController extends Controller
{
    public function estatisticaEvolucao(Request $request)
    {
        // Capturar os anos do request
        $anoinicio = request('anoinicio', date('Y') - 4);
        $anofinal = request('anofinal', date('Y'));
        $regiao_id = auth()->user()->pessoa->regiao_id;

        // Criar as colunas dos anos dinamicamente
        $colunasAno = [];
        for ($ano = $anoinicio; $ano <= $anofinal; $ano++) {
            $colunasAno[] = "
                SUM(
                    CASE
                        WHEN YEAR(mrp.dt_recepcao) = $ano THEN 1 ELSE 0
                    END
                ) -
                SUM(
                    CASE
                        WHEN YEAR(mrp.dt_exclusao) = $ano THEN 1 ELSE 0
                    END
                ) AS `$ano`
            ";
        }

        // Obter a primeira e a última coluna para evolução
        $valorAnoInicial = "`$anoinicio`";
        $valorAnoFinal = "`$anofinal`";

        // Construir a Query SQL otimizada
        $sql = "
            SELECT
                inst.nome,
                " . implode(", ", $colunasAno) . ",
                ($valorAnoFinal - $valorAnoInicial) AS Evolucao,
                CASE
                    WHEN $valorAnoInicial = 0 THEN 100 * ($valorAnoFinal - $valorAnoInicial)
                    ELSE ROUND(
                        (($valorAnoFinal - $valorAnoInicial) / NULLIF($valorAnoInicial, 0)) * 100, 2
                    )
                END AS Percentual
            FROM membresia_rolpermanente mrp
            INNER JOIN instituicoes_instituicoes inst ON inst.id = mrp.distrito_id
            WHERE mrp.status = 'A' AND mrp.regiao_id = ?
            AND YEAR(mrp.dt_recepcao) BETWEEN ? AND ?
            GROUP BY inst.nome
        ";

        // Executar a Query
        $dados = DB::select($sql, [$regiao_id, $anoinicio, $anofinal]);

        return view('regiao.estatisticas.evolucao', compact('dados', 'anoinicio', 'anofinal'));
    }
}
