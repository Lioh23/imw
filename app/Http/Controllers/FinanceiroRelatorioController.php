<?php

namespace App\Http\Controllers;

use App\Services\ServiceFinanceiroRelatorios\BalanceteService;
use App\Services\ServiceFinanceiroRelatorios\LivroCaixaService;
use App\Services\ServiceFinanceiroRelatorios\LivroGradeService;
use App\Services\ServiceFinanceiroRelatorios\SalvarLivroGradeService;
use App\Services\ServiceFinanceiroRelatorios\MovimentoDiarioService;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;


class FinanceiroRelatorioController extends Controller
{
    public function balancetePdf(Request $request)
    {
        $dataInicial = $request->input('dt_inicial');
        $dataFinal = $request->input('dt_final');
        $caixaId = $request->input('caixa_id');

        // Se dataInicial estiver vazia, defina como o primeiro dia do mês atual
        if (empty($dataInicial)) {
            $dataInicial = Carbon::now()->startOfMonth()->format('Y-m-d');
        }

        // Se dataFinal estiver vazia, defina como o último dia do mês atual
        if (empty($dataFinal)) {
            $dataFinal = Carbon::now()->endOfMonth()->format('Y-m-d');
        }

        $data = app(BalanceteService::class)->execute($dataInicial, $dataFinal, $caixaId);

        $pdf = FacadePdf::loadView('financeiro.relatorios.balancete_pdf', $data);
        return $pdf->stream('balancete.pdf');
    }

    public function  movimentodiario(Request $request)
    {
        $dataInicial = $request->input('dt_inicial');
        $dataFinal = $request->input('dt_final');
        $caixaId = $request->input('caixa_id');

        $data = app(MovimentoDiarioService::class)->execute($dataInicial, $dataFinal, $caixaId);

        return view('financeiro.relatorios.movimentodiario', $data);
    }

    public function movimentoDiarioPdf(Request $request)
    {
        $dataInicial = $request->input('dt_inicial');
        $dataFinal = $request->input('dt_final');
        $caixaId = $request->input('caixa_id');

        $data = app(MovimentoDiarioService::class)->execute($dataInicial, $dataFinal, $caixaId);

        $pdf = FacadePdf::loadView('financeiro.relatorios.movimento-diario-pdf', $data);
        return $pdf->stream('relatorio_movimento_diario.pdf');
    }


    public function  livrocaixa(Request $request)
    {
        $dt = $request->input('dt');
        $caixaId = $request->input('caixa_id');

        $data = app(LivroCaixaService::class)->execute($dt, $caixaId);
        return view('financeiro.relatorios.livrocaixa', $data);
    }

    public function livrocaixaPdf(Request $request)
    {
        $dt = $request->input('dt');
        $caixaId = $request->input('caixa_id');

        $data = app(LivroCaixaService::class)->execute($dt, $caixaId);

        $pdf = FacadePdf::loadView('financeiro.relatorios.livrocaixa_pdf', $data);
        return $pdf->stream('relatorio_livrocaixa.pdf');
    }

    public function livrogradepost(Request $request)
    {
        $ano = $request->input('ano');

        $data = app(LivroGradeService::class)->execute($ano);
        return $data;
    }

    public function  balancete(Request $request)
    {
        $dataInicial = $request->input('dt_inicial');
        $dataFinal = $request->input('dt_final');
        $caixaId = $request->input('caixa_id');

        $data = app(BalanceteService::class)->execute($dataInicial, $dataFinal, $caixaId);

        return view('financeiro.relatorios.balancete', $data);
    }

    public function livrogradestore(Request $request)
    {
        $data = app(SalvarLivroGradeService::class)->execute($request);
        return $data;
    }


    public function  livrorazao()
    {
        return view('financeiro.relatorios.livrorazao');
    }

    public function  livrograde()
    {
        return view('financeiro.relatorios.livrograde');
    }
}
