<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFornecedorRequest;
use App\Services\ServiceFonecedor\ListFornecedorService;
use App\Services\ServiceFonecedor\SalvarFornecedorService;
use App\Services\ServiceFornecedor\DeletarFornecedorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function store(StoreFornecedorRequest $request)
    {
        try {
            DB::beginTransaction();
            app(SalvarFornecedorService::class)->execute($request->all());
            DB::commit();
            return redirect()->route('fornecedor.novo')->with('success', 'Fornecedor cadastrado com sucesso.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('fornecedor.novo')->with('error', $e->getMessage());
        }
    }

    public function deletar($id) 
    {
        try {
            DB::beginTransaction();
            app(DeletarFornecedorService::class)->execute($id);
            DB::commit();
            return redirect()->route('financeiro.fornecedores.index')->with('success', 'Fornecedor excluído com sucesso.');
        } catch(\Exception $e) {
            DB::rollback();
            return redirect()->route('financeiro.fornecedores.index')->with('error', $e->getMessage());
        }
    }
}
