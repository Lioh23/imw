<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanceiroRelatorioController extends Controller
{
    public function  movimentodiario() {
        return view('finnceiro.relatorios.movimentodiario');
    }

    public function  livrorazao() {
        return view('finnceiro.relatorios.livrorazao');
    }

    public function  livrocaixa() {
        return view('finnceiro.relatorios.livrocaixa');
    }

    public function  livrograde() {
        return view('finnceiro.relatorios.livrograde');
    }

    public function  balancete() {
        return view('finnceiro.relatorios.balancete');
    }
}
