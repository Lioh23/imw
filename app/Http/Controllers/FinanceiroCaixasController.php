<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCaixasRequest;
use App\Services\ServiceFinanceiroCaixas\DeletarFinanceiroCaixasService;
use App\Services\ServiceFinanceiroCaixas\ListFinanceiroCaixasService;
use App\Services\ServiceFinanceiroCaixas\StoreFinanceiroCaixasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceiroCaixasController extends Controller
{
    public function index(Request $request) {
        $data = app(ListFinanceiroCaixasService::class)->execute($request->all());
        return view('financeiro.caixas.index', $data);
    }

    public function novo() {
        return view('financeiro.caixas.novo');
    }

    public function store(StoreCaixasRequest $request) {
        try {
            DB::beginTransaction();
            app(StoreFinanceiroCaixasService::class)->execute($request->all());
            DB::commit();
            return redirect()->route('financeiro.caixas')->with('success', 'Caixa cadastrado com sucesso.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('financeiro.caixas.novo')->with('error', $e->getMessage());
        }
    }

    public function deletar($id) 
    {
        try {
            DB::beginTransaction();
            app(DeletarFinanceiroCaixasService::class)->execute($id);
            DB::commit();
            return redirect()->route('financeiro.caixas')->with('success', 'Caixa excluído com sucesso.');
        } catch(\Exception $e) {
            DB::rollback();
            return redirect()->route('financeiro.caixas')->with('error', $e->getMessage());
        }
    }
}
