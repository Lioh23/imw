<?php

namespace App\Http\Controllers;

use App\DataTables\GCeuCartaPastoralDatatable;
use App\DataTables\GCeuDatatable;
use App\Http\Requests\StoreGCeuCartaPastoralRequest;
use App\Http\Requests\UpdateVisitanteRequest;
use App\Rules\ValidDateOfBirth;
use App\Http\Requests\StoreGCeuRequest;
use App\Http\Requests\UpdateGCeuCartaPastoralRequest;
use App\Http\Requests\UpdateGCeuRequest;
use App\Models\GCeu;
use App\Models\MembresiaMembro;
use App\Services\ServiceGCeu\CartaPastoralGCeuService;
use App\Services\ServiceGCeu\DeletarGCeuCartaPastoralService;
use App\Services\ServiceGCeu\DeletarGCeuService;
use App\Services\ServiceGCeu\EditarGCeuCartaPastoralService;
use App\Services\ServiceGCeu\EditarGCeuService;
use App\Services\ServiceGCeu\StoreGCeuCartaPastoralService;
use App\Services\ServiceGCeu\StoreGCeuService;
use App\Services\ServiceGCeu\VisualizarGCeuCartaPastoralService;
use App\Services\ServiceGCeu\VisualizarGCeuService;
use App\Services\ServiceVisitantes\DeletarVisitanteService;
use App\Services\ServiceVisitantes\EditarVisitanteService;
use App\Services\ServiceVisitantes\IdentificaDadosIndexService;
use App\Traits\Identifiable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

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
            $existe = GCeu::join('gceu_membros', 'gceu_membros.gceu_cadastro_id','gceu_cadastros.id')->where('gceu_cadastros.id',$id)->first();
            if($existe){
                return back()->with('error', 'Não poderá remover esse CGEU, pois existe membros vinculados.');
            }else{
                app(DeletarGCeuService::class)->execute($id);
                return redirect()->route('gceu.index')->with('success', 'GCEU deletado com sucesso.');
            }
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
    public function cartaPastoral()
    {
        $igrejaId = Identifiable::fetchSessionIgrejaLocal()->id;
        $data = app(CartaPastoralGCeuService::class)->getList($igrejaId);
        if (!$data) {
            return redirect()->route('gceu.carta-pastoral')->with('error', 'Carta pastoral não encontrada.');
        }
        return view('gceu.carta-pastoral.index', $data);
    }
    
    public function cartaPastoralEditar($id)
    {
        $cartaPastoral = app(EditarGCeuCartaPastoralService::class)->findOne($id);
        if (!$cartaPastoral) {
            return redirect()->route('gceu.carta-pastoral')->with('error', 'Carta Pastoral não encontrada.');
        }
        return view('gceu.carta-pastoral.editar', compact('cartaPastoral'));
    }

    public function cartaPastoralUpdate(UpdateGCeuCartaPastoralRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            app(EditarGCeuCartaPastoralService::class)->execute($id, $request->all());
            DB::commit();
            return redirect()->route('gceu.carta-pastoral', ['id' => $id])->with('success', 'Carta Pastoral atualizada com sucesso.');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->route('gceu.carta-pastoral.editar', ['id' => $id])->with('error', 'Falha ao atualizar a Carta Pastoral.');
        }
    }

    public function cartaPastoralDeletar($id)
    {
        try {
            app(DeletarGCeuCartaPastoralService::class)->execute($id);
            return redirect()->route('gceu.carta-pastoral')->with('success', 'Carta pastoral deletada com sucesso.');
        } catch (\Exception $e) {
            return back()->with('error', 'Falha ao deletar a carta pastoral.');
        }
    }

    public function cartaPastoralNovo()
    {
        try {
            $data['instituicao_id'] = Identifiable::fetchSessionIgrejaLocal()->id;
            $data['instituicao'] = Identifiable::fetchSessionIgrejaLocal()->nome;
            return view('gceu.carta-pastoral.create', $data);
        } catch (\Exception $e) {
            return back()->with('error', 'Falha ao abrir a página nova carta pastoral');
        }
    }

    public function cartaPastoralStore(StoreGCeuCartaPastoralRequest $request)
    {
        try {
            DB::beginTransaction();
            app(StoreGCeuCartaPastoralService::class)->execute($request->all());
            DB::commit();
            return redirect()->route('gceu.carta-pastoral')->with('success', 'Carta pastoral cadastrada com sucesso.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('gceu.carta-pastoral')->with('error', $e->getMessage());
        }
    }

    public function cartaPastoralVisualizarHtml($id)
    {
        $cartaPastoral = app(VisualizarGCeuCartaPastoralService::class)->findOne($id);
        if (!$cartaPastoral) {
            return redirect()->route('gceu.carta-pastoral')->with('error', 'Carta pastoral não encontrada.');
        }
        return view('gceu.carta-pastoral.visualizar', ['cartaPastoral' =>  $cartaPastoral]);
    }

    public function cartaPastoralPdf($id)
    {
        $cartaPastoral = app(VisualizarGCeuCartaPastoralService::class)->findOne($id);
        if (!$cartaPastoral) {
            return redirect()->route('gceu.carta-pastoral')->with('error', 'Carta pastoral não encontrada.');
        }
        //return view('gceu.carta-pastoral.visualizar', ['cartaPastoral' =>  $cartaPastoral]);

        $pdf = FacadePdf::loadView('gceu.carta-pastoral.pdf', ['cartaPastoral' =>  $cartaPastoral]);
        return $pdf->stream('carta-pastoral-'.$cartaPastoral->titulo.'.pdf');
    }
}