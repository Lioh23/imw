<?php

namespace App\Http\Controllers;

use App\Services\ServiceFinanceiroCaixas\ListFinanceiroCaixasService;
use Illuminate\Http\Request;

class FinanceiroCaixasController extends Controller
{
    public function index(Request $request) {
        $data = app(ListFinanceiroCaixasService::class)->execute($request->all());
        return view('financeiro.caixas.index', $data);
    }

    public function storeCaixas(Request $request) {

    }
}
