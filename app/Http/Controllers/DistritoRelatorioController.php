<?php

namespace App\Http\Controllers;

use App\Services\ServiceDistritoRelatorios\LancamentoIgrejasService;
use App\Services\ServiceDistritoRelatorios\LivroRazaoGeralService;
use App\Services\ServiceDistritoRelatorios\SaldoIgrejasService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class DistritoRelatorioController extends Controller
{
    public function lancamentodasigrejas(Request $request)
    {
        $dt = $request->input('dtano');
        $igrejasID = $request->input('igrejas', []);

        $data = app(LancamentoIgrejasService::class)->execute($dt, $igrejasID);
        return view('distrito.relatorios.lancamentodasigrejas', $data);
    }

    public function livrorazaogeral(Request $request)
    {
        $dataInicial = $request->input('dt_inicial');
        $dataFinal = $request->input('dt_final');

        $data = app(LivroRazaoGeralService::class)->execute($dataInicial, $dataFinal);

        return view('distrito.relatorios.livrorazaogeral', $data);
    }

    public function livrorazaogeralPdf(Request $request) {
        dd($request->all());
    }

    public function saldodasigrejas(Request $request)
    {
        $dt = $request->input('dt');

        $data = app(SaldoIgrejasService::class)->execute($dt);
        return view('distrito.relatorios.saldodasigrejas', $data);
    }

    public function saldodasigrejasPdf(Request $request)
    {
            $dt = $request->input('dt');
            $data = app(SaldoIgrejasService::class)->execute($dt);

            $pdf = FacadePdf::loadView('distrito.relatorios.saldodasigrejas_pdf', $data)
            ->setPaper('a4', 'landscape'); 

            return $pdf->stream('relatorio_saldodasigrejas.pdf' . date('YmdHis'));
    }

    public function lancamentodasigrejasPdf(Request $request)
    {
      
            $dt = $request->input('dtano');
            $igrejasID = json_decode($request->input('igrejas'), true);

            $data = app(LancamentoIgrejasService::class)->execute($dt, $igrejasID);

            $pdf = FacadePdf::loadView('distrito.relatorios.lancamentodasigrejas_pdf', $data)
            ->setPaper('a4', 'landscape'); 

            return $pdf->stream('relatorio_lancamentodasigrejas.pdf' . date('YmdHis'));
      
    }
}
