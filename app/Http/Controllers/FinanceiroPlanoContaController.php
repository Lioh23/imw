<?php

namespace App\Http\Controllers;

use App\Services\ServiceFinanceiroPlanoConta\ListFinanceiroPlanoContaService;
use Illuminate\Http\Request;

class FinanceiroPlanoContaController extends Controller
{
    public function index(Request $request) {
        $data = app(ListFinanceiroPlanoContaService::class)->execute($request->all());
        return view('financeiro.planoconta', $data);
    }
}

