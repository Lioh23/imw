<?php

namespace App\Http\Controllers;

use App\Http\Requests\FinanceiroStoreEntradaRequest;
use App\Models\FinanceiroPlanoConta;
use App\Services\ServiceFinanceiro\IdentificaDadosMovimentacoesCaixaService;
use App\Services\ServiceFinanceiro\IdentificaDadosNovaMovimentacaoService;
use App\Services\ServiceFinanceiro\StoreLancamentoEntradaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceiroController extends Controller
{
    public function movimentocaixa()
    {
        try {
            $data = app(IdentificaDadosMovimentacoesCaixaService::class)->execute();
            return view('financeiro.movimentocaixa', $data);
        } catch(\Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível abrir a página de Movimento de Caixa');
        }
    }

    public function entrada()
    {
        try {
            $data = app(IdentificaDadosNovaMovimentacaoService::class)->execute(FinanceiroPlanoConta::TP_ENTRADA);
            return view('financeiro.entrada', $data);
        } catch(\Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível abrir a página de nova movimentação de entrada');
        }
    }

    public function storeEntrada(FinanceiroStoreEntradaRequest $request)
    {
        try {
            DB::begintransaction();
            app(StoreLancamentoEntradaService::class)->execute($request->all());
            DB::commit();
            return redirect()->route('financeiro.entrada')->with('success', 'Lançamento de entrada realizado.')->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Não criar um registro de entrada');
        }
    }

    public function saida()
    {
        try {
            $data = app(IdentificaDadosNovaMovimentacaoService::class)->execute(FinanceiroPlanoConta::TP_SAIDA);
            return view('financeiro.saida', $data);            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível abrir a página de nova movimentação de saída');
        }
    }

    public function transferencia()
    {
        try{
            $data = app(IdentificaDadosNovaMovimentacaoService::class)->execute(FinanceiroPlanoConta::TP_TRANSFERENCIA);
            return view('financeiro.transferencia', $data);
        } catch(\Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível abrir a página de nova movimentação de transferência');
        }
    }

    public function consolidarcaixa()
    {
        try{
            return view('financeiro.consolidarcaixa');
        } catch(\Exception $e) {

        }
    }
}
