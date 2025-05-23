<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\EstatisticaClerigosService\HistoricoNomeacoes;
use App\Services\EstatisticaClerigosService\TotalTicketMedio;
use App\Services\ServiceEstatisticas\TotalMembresiaServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
class RegiaoEstatisticasController extends Controller
{
    public function totalMembresia(Request $request)
    {
        $checkIgreja = $request->input('checkIgreja', 'distrito'); // Padrão para 'distrito' se nada for selecionado

        $dados = app(TotalMembresiaServices::class)->execute($checkIgreja);

        return view('regiao.estatisticas.totalmembresia', [
            'regiao' => $dados['regiao'],
            'dados' => $dados['resultado'],
            'totalGeral' => $dados['totalGeral'],
            'tipo' => $checkIgreja // Passa o tipo para a view
        ]);
    }



    public function estatisticaEvolucao(Request $request)
    {
        // Capturar os anos do request
        $anoinicio = request('anoinicio', date('Y') - 4);
        $anofinal = request('anofinal', date('Y'));
        $regiao_id = auth()->user()->pessoa->regiao_id;

        // ===========================
        // 🔹 Criar colunas de contagem de membros por ano
        // ===========================
        $colunasAnoPais = [];
        $colunasAnoFilhos = [];

        for ($ano = $anoinicio; $ano <= $anofinal; $ano++) {
            // Para os PAIS (distrito_id)
            $colunasAnoPais[] = "
                (SELECT COUNT(*) FROM membresia_rolpermanente
                 WHERE distrito_id = inst.id
                 AND dt_exclusao is null
                 AND YEAR(dt_recepcao) <= $ano
                ) AS `$ano`
            ";

            // Para os FILHOS (igreja_id)
            $colunasAnoFilhos[] = "
                (SELECT COUNT(*) FROM membresia_rolpermanente
                 WHERE igreja_id = inst.id
                 AND dt_exclusao is null
                 AND YEAR(dt_recepcao) <= $ano
                ) AS `$ano`
            ";
        }

        $colunasAnoSQLPais = implode(", ", $colunasAnoPais);
        $colunasAnoSQLFilhos = implode(", ", $colunasAnoFilhos);

        // ===========================
        // 🔹 Buscar os PAIS (instituições na região do usuário)
        // ===========================
        $instituicoes_pais = DB::select("
            SELECT
                inst.id,
                inst.nome AS instituicao,
                inst.instituicao_pai_id,
                $colunasAnoSQLPais,
                (SELECT COUNT(*) FROM membresia_rolpermanente WHERE distrito_id = inst.id and dt_exclusao is null and lastrec = 1) AS total_membros
            FROM instituicoes_instituicoes inst
            WHERE inst.instituicao_pai_id = ?
            ORDER BY inst.nome
        ", [$regiao_id]);

        // 🔹 PEGAR IDS DOS PAIS ENCONTRADOS PARA BUSCAR FILHOS
        $ids_pais = array_column($instituicoes_pais, 'id');

        // ===========================
        // 🔹 Buscar os FILHOS (instituições que pertencem aos pais encontrados)
        // ===========================
        if (!empty($ids_pais)) {
            $instituicoes_filhos = DB::select("
                SELECT
                    inst.id,
                    inst.nome AS instituicao,
                    inst.instituicao_pai_id,
                    $colunasAnoSQLFilhos,
                    (SELECT COUNT(*) FROM membresia_rolpermanente WHERE igreja_id = inst.id and dt_exclusao is null and lastrec = 1) AS total_membros
                FROM instituicoes_instituicoes inst
                WHERE inst.instituicao_pai_id IN (" . implode(',', $ids_pais) . ")
                ORDER BY inst.nome
            ");
        } else {
            $instituicoes_filhos = [];
        }

        return view('regiao.estatisticas.evolucao', compact('instituicoes_pais', 'instituicoes_filhos', 'anoinicio', 'anofinal'));
    }


    public function historiconomeacoes(Request $request)
    {
        $visao = $request->input('visao');
        $data = app(HistoricoNomeacoes::class)->execute($visao);
        return view('regiao.estatisticas.estatisticanomeacoes', $data);
    }


    public function historiconomeacoesPdf(Request $request)
    {
        $visao = $request->input('visao');
        $data = app(HistoricoNomeacoes::class)->execute($visao);

        $pdf = FacadePdf::loadView('regiao.estatisticas.estatisticanomeacoes_pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->stream('relatorio_estatisticanomeacoes.pdf' . date('YmdHis'));
    }
    public function ticketmedio(Request $request)
    {
        $anoinicio =  $request->input('anoinicio', date('Y') - 4);
        $anofinal =  $request->input('anofinal', date('Y'));
        $data = app(TotalTicketMedio::class)->execute($anoinicio, $anofinal);
        return view('regiao.estatisticas.clerigos.estatisticaticketmedio', data: $data);
    }

    public function ticketmedioPdf(Request $request)
    {
        $anoinicio =  $request->input('anoinicio', date('Y') - 4);
        $anofinal =  $request->input('anofinal', date('Y'));
        $data = app(TotalTicketMedio::class)->execute($anoinicio, $anofinal);
        $pdf = FacadePdf::loadView('regiao.estatisticas.estatisticaticketmedio_pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->stream('relatorio_estatisticaticketmedio.pdf' . date('YmdHis'));
    }
}
