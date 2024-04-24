<?php

namespace App\Http\Controllers;

use App\Http\Requests\FinanceiroStoreEntradaRequest;
use App\Http\Requests\FinanceiroStoreSaidaRequest;
use App\Http\Requests\FinanceiroTransferenciaRequest;
use App\Models\Anexo;
use App\Models\FinanceiroPlanoConta;
use App\Services\ServiceFinanceiro\BuscarAnexosServices;
use App\Services\ServiceFinanceiro\ConsolidacaoService;
use App\Services\ServiceFinanceiro\DeletarLancamentoService;
use App\Services\ServiceFinanceiro\IdentificaDadosMovimentacoesCaixaService;
use App\Services\ServiceFinanceiro\IdentificaDadosNovaMovimentacaoService;
use App\Services\ServiceFinanceiro\SaldoService;
use App\Services\ServiceFinanceiro\StoreLancamentoEntradaService;
use App\Services\ServiceFinanceiro\StoreLancamentoSaidaService;
use App\Services\ServiceFinanceiro\StoreTransferenciaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class FinanceiroController extends Controller
{
    public function movimentocaixa(Request $request)
    {
        try {
            $filters = $request->only(['caixa_id', 'plano_conta_id', 'd1', 'd2']);
            $data = app(IdentificaDadosMovimentacoesCaixaService::class)->execute($filters);
    
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
            return redirect()->back()->with('error', 'Não foi possível criar um registro de entrada');
        }
    }

    public function storeTransferencia(FinanceiroTransferenciaRequest $request)
    {
        try {
            DB::begintransaction();
            app(StoreTransferenciaService::class)->execute($request->all());
            DB::commit();
            return redirect()->route('financeiro.transferencia')->with('success', 'Transferência realizada.')->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->with('error', 'Não foi possível criar um registro de transferência');
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

    public function storeSaida(FinanceiroStoreSaidaRequest $request)
    {
        try {
            DB::begintransaction();
            app(StoreLancamentoSaidaService::class)->execute($request->all());
            DB::commit();
            return redirect()->route('financeiro.saida')->with('success', 'Lançamento de saída realizado.')->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->with('error', 'Não foi possível criar um registro de saída');
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
            $data = app(ConsolidacaoService::class)->execute();
            return view('financeiro.consolidarcaixa', $data);
        } catch(\Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível abrir a página');
        }
    }

    public function saldo()
    {
        try{
            $data = app(SaldoService::class)->execute();
            return view('financeiro.saldo', $data);
        } catch(\Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível abrir a página');
        }
    }

       public function buscarAnexos($id) {
        $data = app(BuscarAnexosServices::class)->execute($id);
        return response()->json($data);
    }

    public function excluirMovimento($id) {
        try {
            DB::beginTransaction();
            app(DeletarLancamentoService::class)->execute($id);
            DB::commit();
            return redirect()->route('financeiro.movimento.caixa')->with('success', 'Movimento excluído com sucesso.'); 
        } catch(\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao excluir o movimento: ' . $e->getMessage());
        }
    }
    
}
