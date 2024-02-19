<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisitanteRequest;
use App\Http\Requests\UpdateVisitanteRequest;
use App\Services\DeletarVisitanteService;
use App\Services\EditarVisitanteService;
use App\Services\ListVisitanteService;
use App\Services\StoreVisitanteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitantesController extends Controller
{

    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        $visitantes = app(ListVisitanteService::class)->execute($searchTerm);
        return view('visitantes.index', compact('visitantes'));
    }

    public function update(UpdateVisitanteRequest $request, $id){
        try {
            DB::beginTransaction();
            app(EditarVisitanteService::class)->execute($id, $request->all());
            DB::commit();
            return redirect()->route('visitante.editar', ['id' => $id])->with('success', 'Visitante atualizado com sucesso.');
        } catch(\Exception $e) {
            DB::rollback();
            return redirect()->route('visitante.editar', ['id' => $id])->with('error', 'Falha ao atualizar o visitante.');
       }
    }

    public function editar($id) {
        $visitante = app(EditarVisitanteService::class)->listOne($id);
        if (!$visitante) {
            return redirect()->route('visitante.index')->with('error', 'Visitante não encontrado.');
        }
        return view('visitantes.editar', compact('visitante'));
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
            return redirect()->route('visitante.novo')->with('success', 'Visitante cadastrado com sucesso.');
        } catch(\Exception $e) {
            DB::rollback();
            return redirect()->route('visitante.novo')->with('error', 'Falha ao cadastrar o visitante.');
       }
    }
}
