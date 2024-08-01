<?php

namespace App\Http\Controllers;

use App\Services\ServiceDistritoRelatorios\EstatisticaGeneroService;
use App\Services\ServiceDistritoRelatorios\LancamentoIgrejasService;
use App\Services\ServiceDistritoRelatorios\LivroRazaoGeralService;
use App\Services\ServiceDistritoRelatorios\MembrosMinisterioService;
use App\Services\ServiceDistritoRelatorios\OrcamentoService;
use App\Services\ServiceDistritoRelatorios\QuantidadeMembrosService;
use App\Services\ServiceDistritoRelatorios\SaldoIgrejasService;
use App\Services\ServiceDistritoRelatorios\VariacaoFinanceiraService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class DistritoRelatorioController extends Controller
{
    //Membresia
    public function membrosministerio(Request $request) {
        $dt = $request->input('dtano');
        $tipo = $request->input('tipo');
        $data = app(MembrosMinisterioService::class)->execute($dt, $tipo);
        return view('distrito.relatorios.membrosministerio', $data);
    }

    public function membrosministerioPdf(Request $request) {
        $dt = $request->input('dtano');
        $tipo = $request->input('tipo');
        $data = app(MembrosMinisterioService::class)->execute($dt, $tipo);
        
        $pdf = FacadePdf::loadView('distrito.relatorios.membrosministerio_pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->stream('relatorio_membrosministerio.pdf' . date('YmdHis'));
    }


    public function quantidademembros(Request $request) {
        $dt = $request->input('dtano');
        $data = app(QuantidadeMembrosService::class)->execute($dt);
        return view('distrito.relatorios.quantidademembros', $data);
    }


    public function estatisticagenero(Request $request) {
        $dt = $request->input('dtano');
        $data = app(EstatisticaGeneroService::class)->execute($dt);
        return view('distrito.relatorios.estatisticagenero', $data);
    }


    //Financeiro
    public function lancamentodasigrejas(Request $request)
    {
        $dt = $request->input('dtano');
        $igrejasID = $request->input('igrejas', []);

        $data = app(LancamentoIgrejasService::class)->execute($dt, $igrejasID);
        return view('distrito.relatorios.lancamentodasigrejas', $data);
    }


    public function variacaofinanceira(Request $request)
    {
        $dataInicial = $request->input('dt_inicial');
        $dataFinal = $request->input('dt_final');

        $data = app(VariacaoFinanceiraService::class)->execute($dataInicial, $dataFinal);

        return view('distrito.relatorios.variacaofinanceira', $data);
    }

    public function variacaofinanceiraPdf(Request $request)
    {

        $dataInicial = $request->input('dt_inicial');
        $dataFinal = $request->input('dt_final');

        $data = app(VariacaoFinanceiraService::class)->execute($dataInicial, $dataFinal);

        $pdf = FacadePdf::loadView('distrito.relatorios.variacaofinanceira_pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->stream('relatorio_variacaofinanceira.pdf' . date('YmdHis'));
    }

    public function orcamento(Request $request)
    {
        $dt = $request->input('dtano');

        $data = app(OrcamentoService::class)->execute($dt);
        return view('distrito.relatorios.orcamento', $data);
    }

    public function orcamentoPdf(Request $request)
    {

        $dt = $request->input('dtano');

        $data = app(OrcamentoService::class)->execute($dt);

        $pdf = FacadePdf::loadView('distrito.relatorios.orcamento_pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->stream('relatorio_orcamento.pdf' . date('YmdHis'));
    }


    public function livrorazaogeral(Request $request)
    {
        $dataInicial = $request->input('dt_inicial');
        $dataFinal = $request->input('dt_final');

        $data = app(LivroRazaoGeralService::class)->execute($dataInicial, $dataFinal);

        return view('distrito.relatorios.livrorazaogeral', $data);
    }

    public function livrorazaogeralPdf(Request $request)
    {
        $dataInicial = $request->input('dt_inicial');
        $dataFinal = $request->input('dt_final');

        $data = app(LivroRazaoGeralService::class)->execute($dataInicial, $dataFinal);

        $pdf = FacadePdf::loadView('distrito.relatorios.livrorazaogeral_pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->stream('relatorio_livrorazaogeral.pdf' . date('YmdHis'));
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
