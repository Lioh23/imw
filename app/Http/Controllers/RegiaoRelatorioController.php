<?php

namespace App\Http\Controllers;

use App\Services\ServiceRegiaoRelatorios\EstatisticaGeneroService;
use App\Services\ServiceRegiaoRelatorios\LancamentoIgrejasService;
use App\Services\ServiceRegiaoRelatorios\LivroRazaoGeralService;
use App\Services\ServiceRegiaoRelatorios\MembrosMinisterioService;
use App\Services\ServiceRegiaoRelatorios\OrcamentoService;
use App\Services\ServiceRegiaoRelatorios\QuantidadeMembrosService;
use App\Services\ServiceRegiaoRelatorios\SaldoIgrejasService;
use App\Services\ServiceRegiaoRelatorios\VariacaoFinanceiraService;
use App\Traits\Identifiable;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class RegiaoRelatorioController extends Controller
{
    //Membresia
    public function membrosministerio(Request $request) {
        $dataInicial = $request->input('data_inicial');
        $dataFinal = $request->input('data_final');
        $tipo = $request->input('tipo');
        $distritoId = $request->input('distrito');

        $data = app(MembrosMinisterioService::class)->execute($dataInicial, $dataFinal, $tipo, $distritoId);
        return view('regiao.relatorios.membrosministerio', $data);
    }

    public function membrosministerioPdf(Request $request) {
        $dataInicial = $request->input('dt_inicial');
        $dataFinal = $request->input('dt_final');
        $tipo = $request->input('tipo');
        $distritoId = $request->input('distrito');

        $data = app(MembrosMinisterioService::class)->execute($dataInicial, $dataFinal, $tipo, $distritoId);
        
        $pdf = FacadePdf::loadView('regiao.relatorios.membrosministerio_pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->stream('relatorio_membrosministerio.pdf' . date('YmdHis'));
    }


    public function quantidademembros(Request $request) {
        $dataInicial = $request->input('data_inicial');
        $dataFinal = $request->input('data_final');
        $tipo = $request->input('tipo');
        $distritoId = $request->input('distrito');

        $data = app(QuantidadeMembrosService::class)->execute($dataInicial, $dataFinal, $tipo, $distritoId);
        return view('regiao.relatorios.quantidademembros', $data);
    }

    public function quantidademembrosPdf(Request $request) {
        $dataInicial = $request->input('data_inicial');
        $dataFinal = $request->input('data_final');
        $tipo = $request->input('tipo');
        $distritoId = $request->input('distrito');

        $data = app(QuantidadeMembrosService::class)->execute($dataInicial, $dataFinal, $tipo, $distritoId);
        $pdf = FacadePdf::loadView('regiao.relatorios.quantidademembros_pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->stream('relatorio_quantidademembros.pdf' . date('YmdHis'));
    }


    public function estatisticagenero(Request $request) {
        $dataInicial = $request->input('data_inicial');
        $dataFinal = $request->input('data_final');
        $tipo = $request->input('tipo');
        $distritoId = $request->input('distrito');

        $data = app(EstatisticaGeneroService::class)->execute($dataInicial, $dataFinal, $tipo, $distritoId);
        return view('regiao.relatorios.estatisticagenero', $data);
    }

    public function estatisticageneroPdf(Request $request) {
        $dataInicial = $request->input('data_inicial');
        $dataFinal = $request->input('data_final');
        $tipo = $request->input('tipo');
        $distritoId = $request->input('distrito');

        $data = app(EstatisticaGeneroService::class)->execute($dataInicial, $dataFinal, $tipo, $distritoId);
        
        $pdf = FacadePdf::loadView('regiao.relatorios.estatisticagenero_pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->stream('relatorio_estatisticagenero.pdf' . date('YmdHis'));
    }


    //Financeiro
    public function lancamentodasigrejas(Request $request)
    {
        $dt = $request->input('dtano');
        $igrejaId = $request->input('igreja_id');
        $regiao = Identifiable::fetchtSessionRegiao();

        $data = app(LancamentoIgrejasService::class)->execute($dt, $igrejaId, $regiao);
        return view('regiao.relatorios.lancamentodasigrejas', $data);
    }


    public function variacaofinanceira(Request $request)
    {
        $dataInicial = $request->input('dt_inicial');
        $dataFinal = $request->input('dt_final');
        $distritoId = $request->input('distrito');

        $data = app(VariacaoFinanceiraService::class)->execute($dataInicial, $dataFinal, $distritoId);

        return view('regiao.relatorios.variacaofinanceira', $data);
    }

    public function variacaofinanceiraPdf(Request $request)
    {

        $dataInicial = $request->input('dt_inicial');
        $dataFinal = $request->input('dt_final');
        $distritoId = $request->input('distrito');

        $data = app(VariacaoFinanceiraService::class)->execute($dataInicial, $dataFinal, $distritoId);

        $pdf = FacadePdf::loadView('regiao.relatorios.variacaofinanceira_pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->stream('relatorio_variacaofinanceira.pdf' . date('YmdHis'));
    }

    public function orcamento(Request $request)
    {
        $dt = $request->input('dtano');
        $distritoId = $request->input('distrito');

        $data = app(OrcamentoService::class)->execute($dt, $distritoId);
        return view('regiao.relatorios.orcamento', $data);
    }

    public function orcamentoPdf(Request $request)
    {
        $dt = $request->input('dtano');
        $distritoId = $request->input('distrito');

        $data = app(OrcamentoService::class)->execute($dt, $distritoId);

        $pdf = FacadePdf::loadView('regiao.relatorios.orcamento_pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->stream('relatorio_orcamento.pdf' . date('YmdHis'));
    }


    public function livrorazaogeral(Request $request)
    {
        $dataInicial = $request->input('dt_inicial');
        $dataFinal = $request->input('dt_final');
        $distrtoId = $request->input('distrito');
        $igrejaId = $request->input('igreja');

        $data = app(LivroRazaoGeralService::class)->execute($dataInicial, $dataFinal, $distrtoId, $igrejaId);

        return view('regiao.relatorios.livrorazaogeral', $data);
    }

    public function livrorazaogeralPdf(Request $request)
    {
        $dataInicial = $request->input('dt_inicial');
        $dataFinal = $request->input('dt_final');
        $distritoId = $request->input('distrito');
        $igrejaId = $request->input('igreja');

        $data = app(LivroRazaoGeralService::class)->execute($dataInicial, $dataFinal, $distritoId, $igrejaId);

        $pdf = FacadePdf::loadView('regiao.relatorios.livrorazaogeral_pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->stream('relatorio_livrorazaogeral.pdf' . date('YmdHis'));
    }

    public function saldodasigrejas(Request $request)
    {
        $dt = $request->input('dt');
        $distrtoId = $request->input('distrito');

        $data = app(SaldoIgrejasService::class)->execute($dt, $distrtoId);
        return view('regiao.relatorios.saldodasigrejas', $data);
    }

    public function saldodasigrejasPdf(Request $request)
    {
        $dt = $request->input('dt');
        $distrtoId = $request->input('distrito');

        $data = app(SaldoIgrejasService::class)->execute($dt, $distrtoId);

        $pdf = FacadePdf::loadView('regiao.relatorios.saldodasigrejas_pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->stream('relatorio_saldodasigrejas.pdf' . date('YmdHis'));
    }

    public function lancamentodasigrejasPdf(Request $request)
    {

        $dt = $request->input('dtano');
        $igrejaId = $request->input('igreja_id');
        $regiao = Identifiable::fetchtSessionRegiao();

        $data = app(LancamentoIgrejasService::class)->execute($dt, $igrejaId, $regiao);

        $pdf = FacadePdf::loadView('regiao.relatorios.lancamentodasigrejas_pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->stream('relatorio_lancamentodasigrejas.pdf' . date('YmdHis'));
    }
}