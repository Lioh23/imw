<?php

namespace App\Http\Controllers;

use App\DataTables\GCeuDatatable;
use App\Http\Requests\UpdateVisitanteRequest;
use App\Rules\ValidDateOfBirth;
use App\Http\Requests\StoreGCeuRequest;
use App\Http\Requests\UpdateGCeuRequest;
use App\Models\GCeu;
use App\Models\MembresiaMembro;
use App\Services\ServiceGCeu\DeletarGCeuService;
use App\Services\ServiceGCeu\EditarGCeuService;
use App\Services\ServiceGCeu\StoreGCeuService;
use App\Services\ServiceGCeu\VisualizarGCeuService;
use App\Services\ServiceVisitantes\DeletarVisitanteService;
use App\Services\ServiceVisitantes\EditarVisitanteService;
use App\Services\ServiceVisitantes\IdentificaDadosIndexService;
use App\Traits\Identifiable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GceuController extends Controller
{
    use Identifiable;

    public function index(Request $request)
    {
        $data = app(IdentificaDadosIndexService::class)->execute($request->all());

        return view('gceu.index', $data);
    }

    public function list(Request $request)
    {
        try {
            return app(GCeuDatatable::class)->execute($request->all());
        } catch (\Exception $e) {
            return response()->json(['error' => 'erro ao carregar os dados GCEU'], 500);
        }
    }

    public function editar($id)
    {
        $gceu = app(EditarGCeuService::class)->findOne($id);
        $congregacoes = Identifiable::fetchCongregacoes();
        if (!$gceu) {
            return redirect()->route('gceu.index')->with('error', 'GCEU não encontrado.');
        }
        return view('gceu.editar', compact('gceu', 'congregacoes'));
    }

    public function update(UpdateGCeuRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            app(EditarGCeuService::class)->execute($id, $request->all());
            DB::commit();
            return redirect()->route('gceu.editar', ['id' => $id])->with('success', 'GCEU atualizado com sucesso.');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->route('gceu.editar', ['id' => $id])->with('error', 'Falha ao atualizar o GCEU.');
        }
    }

    public function deletar($id)
    {
        $congregacoes = Identifiable::fetchCongregacoes();
        try {
            app(DeletarGCeuService::class)->execute($id);
            return redirect()->route('gceu.index')->with('success', 'GCEU deletado com sucesso.');
        } catch (\Exception $e) {
            return back()->with('error', 'Falha ao deletar o GCEU.');
        }
    }

    public function novo()
    {
        try {
            return view('gceu.create', ['congregacoes' => Identifiable::fetchCongregacoes(), 'instituicao_id' => Identifiable::fetchSessionIgrejaLocal()->id]);
        } catch (\Exception $e) {
            return back()->with('error', 'Falha ao abrir a página de novo visitante');
        }
    }

    public function store(StoreGCeuRequest $request)
    {
        try {
            DB::beginTransaction();
            app(StoreGCeuService::class)->execute($request->all());
            DB::commit();
            return redirect()->route('gceu.index')->with('success', 'GCEU cadastrado com sucesso.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('gceu.index')->with('error', $e->getMessage());
        }
    }

    public function visualizarHtml($id)
    {
        $gceu = app(VisualizarGCeuService::class)->findOne($id);
        if (!$gceu) {
            return redirect()->route('gceu.index')->with('error', 'GCEU não encontrado.');
        }
        return view('gceu.visualizar', ['gceu' =>  $gceu]);
    }
}