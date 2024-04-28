<?php

namespace App\Http\Controllers;

use App\Services\ServiceFinanceiroRelatorios\MovimentoDiarioService;
use Illuminate\Http\Request;

class FinanceiroRelatorioController extends Controller
{
    public function  movimentodiario(Request $request) {
        $dataInicial = $request->input('dt_inicial');
        $dataFinal = $request->input('dt_final');
        $caixaId = $request->input('caixa_id');
    
        $data = app(MovimentoDiarioService::class)->execute($dataInicial, $dataFinal, $caixaId);
    
        return view('financeiro.relatorios.movimentodiario', $data);
    }

    public function  livrorazao() {
        return view('financeiro.relatorios.livrorazao');
    }

    public function  livrocaixa() {
        return view('financeiro.relatorios.livrocaixa');
    }

    public function  livrograde() {
        return view('financeiro.relatorios.livrograde');
    }

    public function  balancete() {
        return view('financeiro.relatorios.balancete');
    }
}
