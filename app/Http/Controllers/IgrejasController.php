<?php

namespace App\Http\Controllers;

use App\Models\InstituicoesInstituicao;
use App\Services\ServiceDatatable\IgrejasDataTable;
use App\Services\ServiceIgrejas\BalanceteService;
use App\Services\ServiceIgrejas\GetEstatisticaAnoEclesiasticoService;
use App\Traits\BalanceteUtils;
use App\Traits\LocationUtils;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;

class IgrejasController extends Controller
{
    use LocationUtils, BalanceteUtils;

    public function index()
    {
        return view('igrejas.index');
    }

    public function list(Request $request)
    {
        try {
            return app(IgrejasDataTable::class)->execute($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Não foi possível listar as igrejas'], 500);
        }
    }

    public function estatisticaAnoEclesiastico(Request $request, InstituicoesInstituicao $igreja)
    {
        try {
            $data = app(GetEstatisticaAnoEclesiasticoService::class)->execute($igreja, $request->input('ano'));
            return view('igrejas.estatistica-ano-eclesiastico', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Houve um erro ao tentar visualizar o relatório de histórico eclesiástico');
        }
    }

    public function balancete(Request $request)
    {
        $dataInicial = $request->input('dt_inicial');
        $dataFinal = $request->input('dt_final');
        $caixaId = $request->input('caixa_id');
        $igrejaId = $request->input('igreja_id');

        $data = app(BalanceteService::class)->execute($dataInicial, $dataFinal, $caixaId, $igrejaId);

        return view('igrejas.balancete', $data);
    }

    public function balancetePdf(Request $request)
    {
        $dataInicial = $request->input('dt_inicial');
        $dataFinal = $request->input('dt_final');
        $caixaId = $request->input('caixa_id');
        $igrejaId = $request->input('igreja_id');

        $data = app(BalanceteService::class)->execute($dataInicial, $dataFinal, $caixaId, $igrejaId);

        $pdf = FacadePdf::loadView('financeiro.relatorios.balancete_pdf', $data);
        return $pdf->stream('balancete.pdf');
    }

    public function listaCaixas(InstituicoesInstituicao $igreja)
    {
        return response()->json($igreja->caixas);
    }
}
