<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisitanteRequest;
use App\Services\DeletarVisitanteService;
use App\Services\ListVisitanteService;
use App\Services\PesquisarVisitanteService;
use App\Services\StoreVisitanteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitantesController extends Controller
{

    public function index()
    {
        $visitantes = app(ListVisitanteService::class)->execute();
        return view('visitantes.index', compact('visitantes'));
    }

    public function pesquisar(Request $request)
    {
        $searchTerm = $request->input('search');
        $visitantes = app(PesquisarVisitanteService::class)->execute($searchTerm);
        return view('visitantes.index', compact('visitantes'));
    }

    public function editar($id) {
        dd($id);
    }

    public function deletar($id) {
        if (app(DeletarVisitanteService::class)->execute($id)) {
            return redirect()->route('visitante.index')->with('success', 'Visitante deletado com sucesso.');
        } else {
            return back()->with('error', 'Falha ao deletar o visitante.');
        }
    }

    public function novo()
    {
        return view('visitantes.create');
    }

    public function store(StoreVisitanteRequest $request)
    {
       try {
            DB::beginTransaction();
            app(StoreVisitanteService::class)->execute($request->all());
            DB::commit();
            return redirect()->route('visitante.novo')->with('success', 'Operação concluída com sucesso!');
        } catch(\Exception $e) {
            DB::rollback();
            return redirect()->route('visitante.novo')->with('error', 'Operação concluída com sucesso!');
       }
    }
}
