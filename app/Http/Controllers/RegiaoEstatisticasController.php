<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

        // Criar as colunas dos anos dinamicamente com soma progressiva
        $colunasAno = [];
        $colunaAcumulada = "0"; // Iniciar a variável acumulada

        for ($ano = $anoinicio; $ano <= $anofinal; $ano++) {
            // Contagem de membros recebidos no ano
            $totalAno = "SUM(CASE WHEN YEAR(mrp.dt_recepcao) = $ano THEN 1 ELSE 0 END)";

            // Contagem de membros excluídos no ano (somente se total > 0)
            $exclusoes = "SUM(CASE WHEN YEAR(mrp.dt_exclusao) = $ano THEN 1 ELSE 0 END)";

            // Ajustar para não subtrair se o total já for 0
            $colunaAcumulada = "(
            $colunaAcumulada +
            $totalAno -
            CASE
                WHEN ($colunaAcumulada + $totalAno) <= 0 THEN 0
                ELSE $exclusoes
            END
        )";

            // Criar a coluna com a soma progressiva
            $colunasAno[] = "$colunaAcumulada AS `$ano`";
        }

        // Obter o acumulado do primeiro ano (Ano Inicial)
        $valorAnoInicial = str_replace(" AS `$anoinicio`", "", reset($colunasAno));

        // Obter o acumulado do último ano (Ano Final)
        $valorAnoFinal = str_replace(" AS `$anofinal`", "", end($colunasAno));

        // Construir a Query SQL
        $sql = "
        SELECT
            inst.nome,
            " . implode(", ", $colunasAno) . ",

            -- Cálculo da Evolução Acumulada
            ($valorAnoFinal - $valorAnoInicial) AS Evolucao,

            -- Cálculo do Percentual de Crescimento
            CASE
                WHEN $valorAnoInicial = 0 THEN 100 * ($valorAnoFinal - $valorAnoInicial)
                ELSE ROUND(
                    (($valorAnoFinal - $valorAnoInicial) / NULLIF($valorAnoInicial, 0)) * 100, 2
                )
            END AS Percentual

        FROM membresia_rolpermanente mrp
        INNER JOIN instituicoes_instituicoes inst ON inst.id = mrp.distrito_id
        LEFT JOIN instituicoes_instituicoes inst_pai ON inst.instituicoes_pai_id = inst_pai.id
        WHERE mrp.status = 'A'
        AND (mrp.regiao_id = ? OR inst.instituicoes_pai_id IN (SELECT id FROM instituicoes_instituicoes WHERE regiao_id = ?))
        AND YEAR(mrp.dt_recepcao) BETWEEN ? AND ?
        GROUP BY inst.nome, inst_pai.nome, mrp.distrito_id, mrp.regiao_id
    ";

        $dados = DB::select($sql, [$regiao_id, $regiao_id, $anoinicio, $anofinal]);


        return view('regiao.estatisticas.evolucao', compact('dados', 'anoinicio', 'anofinal'));
    }
}
