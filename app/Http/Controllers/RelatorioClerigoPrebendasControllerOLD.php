<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceRelatorioClerigoPrebendas\ClerigoAniversariantes;
use App\Services\EstatisticaClerigosService\TotalTicketMedio;
use App\Services\ServiceEstatisticas\TotalMembresiaServices;
use App\Services\ServiceRelatorioClerigoPrebendas\ClerigoDados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
class RelatorioClerigoPrebendasController extends Controller
{
    public function clerigoAniversariante(Request $request)
    {
        $visao = $request->input('visao');
        $data = app(ClerigoAniversariantes::class)->execute($request->all());
        return view('regiao.relatorios.clerigos-prebendas.clerigos-aniversariantes', $data);
    }

    public function clerigoDados(Request $request)
    {
        $data = app(ClerigoDados::class)->execute($request->all());
        return view('regiao.relatorios.clerigos-prebendas.clerigos-dados', $data);
    }



    // public function ticketmedio(Request $request)
    // {
    //     $anoinicio =  $request->input('anoinicio', date('Y') - 4);
    //     $anofinal =  $request->input('anofinal', date('Y'));
    //     $data = app(TotalTicketMedio::class)->execute($anoinicio, $anofinal);
    //     return view('regiao.estatisticas.clerigos.estatisticaticketmedio', data: $data);
    // }

    // public function ticketmedioPdf(Request $request)
    // {
    //     $anoinicio =  $request->input('anoinicio', date('Y') - 4);
    //     $anofinal =  $request->input('anofinal', date('Y'));
    //     $data = app(TotalTicketMedio::class)->execute($anoinicio, $anofinal);
    //     $pdf = FacadePdf::loadView('regiao.estatisticas.estatisticaticketmedio_pdf', $data)
    //         ->setPaper('a4', 'landscape');

    //     return $pdf->stream('relatorio_estatisticaticketmedio.pdf' . date('YmdHis'));
    // }
}
