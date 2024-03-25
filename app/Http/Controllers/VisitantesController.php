<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisitanteRequest;
use App\Http\Requests\UpdateVisitanteRequest;
use App\Services\ServiceMembrosGeral\DeletarMembroService;
use App\Services\ServiceVisitantes\EditarVisitanteService;
use App\Services\ServiceVisitantes\ListVisitanteService;
use App\Services\ServiceVisitantes\StoreVisitanteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VisitantesController extends Controller
{

    public function index(Request $request)
    {
        $data = app(ListVisitanteService::class)->execute($request->all());
        return view('visitantes.index', $data);
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
        $visitante = app(EditarVisitanteService::class)->findOne($id);
        if (!$visitante) {
            return redirect()->route('visitante.index')->with('error', 'Visitante não encontrado.');
        }
        return view('visitantes.editar', compact('visitante'));
    }

    public function deletar($id) {
        try {
            app(DeletarMembroService::class)->execute($id);
            return redirect()->route('visitante.index')->with('success', 'Visitante deletado com sucesso.');
        } catch(\Exception $e) {
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
            return redirect()->route('visitante.novo')->with('error', $e);
       }
    }
}
