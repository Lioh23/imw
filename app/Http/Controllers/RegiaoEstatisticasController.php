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

        // Buscar os anos reais que existem no banco de dados
        $anosDisponiveis = DB::table('membresia_rolpermanente')
            ->selectRaw('DISTINCT YEAR(dt_recepcao) as ano')
            ->whereBetween(DB::raw('YEAR(dt_recepcao)'), [$anoinicio, $anofinal])
            ->where('regiao_id', $regiao_id)
            ->orderBy('ano')
            ->pluck('ano')
            ->toArray();

        // Se não houver anos disponíveis, retorna sem consulta SQL
        if (empty($anosDisponiveis)) {
            return view('regiao.estatisticas.evolucao', compact('anoinicio', 'anofinal'))->with('dados', []);
        }

        // Criar as colunas dos anos dinamicamente (apenas anos que existem no banco)
        $colunasAno = [];
        foreach ($anosDisponiveis as $ano) {
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

        // Obter a primeira e última coluna para evolução
        $valorAnoInicial = "`" . reset($anosDisponiveis) . "`";
        $valorAnoFinal = "`" . end($anosDisponiveis) . "`";

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
            GROUP BY inst.nome
        ";

        // Executar a Query
        $dados = DB::select($sql, [$regiao_id]);

        return view('regiao.estatisticas.evolucao', compact('dados', 'anosDisponiveis', 'anoinicio', 'anofinal'));
    }
}
