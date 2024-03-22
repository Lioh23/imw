<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function index(){
        return view('financeiro.fornecedores.index');
    }

    public function novo(){
        return view('financeiro.fornecedores.novo');
    }  
}
