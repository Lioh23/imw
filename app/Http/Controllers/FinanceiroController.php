<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanceiroController extends Controller
{
    public function movimentocaixa(){
        return view('financeiro.movimentocaixa');
    }

    public function consolidarcaixa(){
        return view('financeiro.consolidarcaixa');
    }

    public function planoconta(){
        return view('financeiro.planoconta');
    }

    public function caixas(){
        return view('financeiro.caixas');
    }

    public function fornecedores(){
        return view('financeiro.fornecedores');
    }

}
