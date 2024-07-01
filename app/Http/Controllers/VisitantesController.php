<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisitanteRequest;
use App\Http\Requests\UpdateVisitanteRequest;
use App\Rules\ValidDateOfBirth;
use App\Services\ServiceDatatable\VisitantesDatatable;
use App\Services\ServiceVisitantes\DeletarVisitanteService;
use App\Services\ServiceVisitantes\EditarVisitanteService;
use App\Services\ServiceVisitantes\IdentificaDadosIndexService;
use App\Services\ServiceVisitantes\StoreVisitanteService;
use App\Traits\Identifiable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitantesController extends Controller
{
    use Identifiable;

    public function index(Request $request)
    {
        $data = app(IdentificaDadosIndexService::class)->execute($request->all());
        return view('visitantes.index', $data);
    }

    public function list(Request $request)
    {
        try {
            return app(VisitantesDatatable::class)->execute($request->all());
        } catch (\Exception $e) {
            return response()->json(['error' => 'erro ao carregar os dados dos visitantes'], 500);
        }
    }

    public function update(UpdateVisitanteRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            app(EditarVisitanteService::class)->execute($id, $request->all());
            DB::commit();
            return redirect()->route('visitante.editar', ['id' => $id])->with('success', 'Visitante atualizado com sucesso.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('visitante.editar', ['id' => $id])->with('error', 'Falha ao atualizar o visitante.');
        }
    }

    public function editar($id)
    {
        $visitante = app(EditarVisitanteService::class)->findOne($id);
        $congregacoes = Identifiable::fetchCongregacoes();
        if (!$visitante) {
            return redirect()->route('visitante.index')->with('error', 'Visitante não encontrado.');
        }
        return view('visitantes.editar', compact('visitante', 'congregacoes'));
    }

    public function deletar($id)
    {
        try {
            app(DeletarVisitanteService::class)->execute($id);
            return redirect()->route('visitante.index')->with('success', 'Visitante deletado com sucesso.');
        } catch (\Exception $e) {
            return back()->with('error', 'Falha ao deletar o visitante.');
        }
    }

    public function novo()
    {
        try {
            return view('visitantes.create', ['congregacoes' => Identifiable::fetchCongregacoes()]);
        } catch (\Exception $e) {
            return back()->with('error', 'Falha ao abrir a página de novo visitante');
        }
    }

    public function store(StoreVisitanteRequest $request)
    {
        try {
            $request->validate([
                'birth_date' => ['required', 'date', new ValidDateOfBirth($request->input('conversion_date'))],
                'conversion_date' => 'required|date',
            ]);
            DB::beginTransaction();
            app(StoreVisitanteService::class)->execute($request->all());
            DB::commit();
            return redirect()->route('visitante.index')->with('success', 'Visitante cadastrado com sucesso.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('visitante.index')->with('error', $e->getMessage());
        }
    }
}