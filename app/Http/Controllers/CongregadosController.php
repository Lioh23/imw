<?php

namespace App\Http\Controllers;

use App\Exceptions\MembroNotFoundException;
use App\Http\Requests\StoreCongregadoRequest;
use App\Models\MembresiaMembro;
use App\Services\ServiceMembrosGeral\DeletarMembroService;
use App\Services\ServiceMembrosGeral\EditarMembroService;
use App\Services\ServiceMembrosGeral\UpdateMembroService;
use App\Services\ServicesCongregados\EditarCongregadoService;
use App\Services\ServicesCongregados\ListCongregadosService;
use App\Services\ServicesCongregados\NovoCongregadoService;
use App\Services\ServicesCongregados\SalvarCongregadoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CongregadosController extends Controller
{
    public function index(Request $request) {
        $congregados = app(ListCongregadosService::class)->execute($request->get('search'));
        return view('congregados.index', compact('congregados'));
    }

    public function novo() {
     
        try {
            $pessoa = app(NovoCongregadoService::class)->execute();
            
            return view('congregados.novo.index', [
                'ministerios'          => $pessoa['ministerios'],
                'funcoes'              => $pessoa['funcoes'],
                'cursos'               => $pessoa['cursos'],
                'formacoes'            => $pessoa['formacoes'],
                'funcoesEclesiasticas' => $pessoa['funcoesEclesiasticas'],
            ]);
        } catch(MembroNotFoundException $e) {
            return redirect()->route('congregado.index')->with('error', 'Registro não encontrado.');
        } catch(\Exception $e) {
            return redirect()->route('congregado.index')->with('error', 'Erro ao abrir a página, por favor, tente mais tarde!');
        }
    
    }

    public function store(StoreCongregadoRequest $request)
    {
       try {
            DB::beginTransaction();
            $membroID = app(SalvarCongregadoService::class)->execute($request->all());
            DB::commit();
            return redirect()->action([CongregadosController::class, 'editar'], ['id' => $membroID])->with('success', 'Registro atualizado.');
        } catch(\Exception $e) {

        } catch(\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->route('congregado.index')->with('success', 'Falha na criação do registro.');
        }
    }

    public function update(StoreCongregadoRequest $request)
    {
       try {
            DB::beginTransaction();
            app(UpdateMembroService::class)->execute($request->all(), MembresiaMembro::VINCULO_CONGREGADO);
            DB::commit();
            return redirect()->action([CongregadosController::class, 'editar'], ['id' => $request->input('membro_id')])->with('success', 'Registro atualizado.');
        } catch(\Exception $e) {
            DB::rollback();
            return redirect()->action([CongregadosController::class, 'editar'], ['id' => $request->input('membro_id')])->with('error', 'Falha na atualização do registro.');
       
        }
    }
    
    public function editar($id) 
    {    
        try {
            $pessoa = app(EditarMembroService::class)->findOne($id);
            
            return view('congregados.editar.index', [
                'pessoa'               => $pessoa['pessoa'],
                'ministerios'          => $pessoa['ministerios'],
                'funcoes'              => $pessoa['funcoes'],
                'cursos'               => $pessoa['cursos'],
                'formacoes'            => $pessoa['formacoes'],
                'funcoesEclesiasticas' => $pessoa['funcoesEclesiasticas'],
            ]);
        } catch(MembroNotFoundException $e) {
            return redirect()->route('visitante.index')->with('error', 'Registro não encontrado.');
        } catch(\Exception $e) {
            return redirect()->route('visitante.index')->with('error', 'Erro ao abrir a página, por favor, tente mais tarde!');
        }
    }

    public function deletar($id)
    {
        try {
            app(DeletarMembroService::class)->execute($id);
            return redirect()->route('congregado.index')->with('success', 'Registro deletado com sucesso.');
        } catch(\Exception $e) {
            return back()->with('error', 'Falha ao deletar o registro.');
        }
    }

}
