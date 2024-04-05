<?php

namespace App\Http\Controllers;

use App\Services\ServiceFonecedor\ListFornecedorService;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function index(Request $request)
    {
        $data = app(ListFornecedorService::class)->execute($request->all());
        return view('financeiro.fornecedores.index', $data);
    }


    public function novo(){
        return view('financeiro.fornecedores.novo');
    }  
}
