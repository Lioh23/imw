<?php

namespace App\Http\Controllers;

use App\Exceptions\IdentificaDadosExcluirMembroException;
use App\Exceptions\MembroNotFoundException;
use App\Exceptions\ReceberNovoMembroException;
use App\Exceptions\ReintegrarMembroException;
use App\Http\Requests\DeletarMembroRequest;
use App\Http\Requests\StoreReceberNovoMembroRequest;
use App\Http\Requests\UpdateMembroRequest;
use App\Models\MembresiaMembro;
use App\Services\ServiceMembros\DeletarMembroService;
use App\Services\ServiceMembros\IdentificaDadosExcluirMembroService;
use App\Services\ServiceMembros\IdentificaDadosReceberNovoMembroService;
use App\Services\ServiceMembros\IdentificaDadosReintegrarMembroService;
use App\Services\ServiceMembros\StoreReceberNovoMembroService;
use App\Services\ServiceMembrosGeral\EditarMembroService;
use App\Services\ServiceMembrosGeral\ListMembrosService;
use App\Services\ServiceMembrosGeral\UpdateMembroService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MembrosController extends Controller
{
    public function index(Request $request) {
        $membros = app(ListMembrosService::class)->execute($request->get('search'));
        return view('membros.index', compact('membros'));
    }
  
    public function editar($id)
    {
        try {
            $pessoa = app(EditarMembroService::class)->findOne($id);
            
            return view('membros.editar.index', [
                'pessoa'               => $pessoa['pessoa'],
                'ministerios'          => $pessoa['ministerios'],
                'funcoes'              => $pessoa['funcoes'],
                'cursos'               => $pessoa['cursos'],
                'formacoes'            => $pessoa['formacoes'],
                'funcoesEclesiasticas' => $pessoa['funcoesEclesiasticas'],
            ]);
        } catch(MembroNotFoundException $e) {
            return redirect()->route('membros.index')->with('error', 'Registro não encontrado.');
        } catch(\Exception $e) {
            return redirect()->route('membros.index')->with('error', 'Erro ao abrir a página, por favor, tente mais tarde!');
        }
    }

    public function update(UpdateMembroRequest $request, $id)
    {   
        try {
            DB::beginTransaction();
            app(UpdateMembroService::class)->execute($request->all(), MembresiaMembro::VINCULO_MEMBRO);
            DB::commit();
            return redirect()->action([MembrosController::class, 'editar'], ['id' => $request->input('membro_id')])->with('success', 'Registro atualizado.');
        } catch(\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->action([MembrosController::class, 'editar'], ['id' => $request->input('membro_id')])->with('error', 'Falha na atualização do registro.');
       
        }
    }

    public function receberNovo($id)
    {
        try {
            $data = app(IdentificaDadosReceberNovoMembroService::class)->execute($id);

            $pessoa       = $data['pessoa'];
            $sugestaoRol  = $data['sugestao_rol'];
            $pastores     = $data['pastores'];
            $modos        = $data['modos'];
            $congregacoes = $data['congregacoes'];

            return view('membros.receber_novo', compact('pessoa', 'sugestaoRol', 'pastores', 'modos', 'congregacoes'));
        } catch(ReceberNovoMembroException $e) {
            return redirect()->back()->with('error', 'Esta pessoa não existe na base de dados ou não pode ser recebida como Membro');
        } catch(\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao exibir a página solicitada');
        }
    }

    public function storeReceberNovo(StoreReceberNovoMembroRequest $request, $id)
    {
        try {
            app(StoreReceberNovoMembroService::class)->execute($request->all(), $id);

            return redirect()->route('membro.editar', ['id' => $id])->with('success', 'Novo membro recebido com sucesso!');
        } catch(\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao tentar receber novo membro');
        }
    }

    public function telaExcluir($id)
    {
        try {
            $data = app(IdentificaDadosExcluirMembroService::class)->execute($id);

            $pessoa       = $data['pessoa'];
            $sugestaoRol  = $data['sugestao_rol'];
            $pastores     = $data['pastores'];
            $modos        = $data['modos'];
    
            return view('membros.excluir', compact('pessoa', 'sugestaoRol', 'pastores', 'modos'));
        } catch(IdentificaDadosExcluirMembroException $e) {
            return redirect()->back()->with('error', 'Erro ao tentar abrir a tela de exclusão de membro');
        } catch(\Exception) {
            return redirect()->back()->with('error', 'Erro ao tentar abrir a tela de exclusão de membro');
        }
    }

    public function deletar(DeletarMembroRequest $request, $id)
    {
        try {
            app(DeletarMembroService::class)->execute($request->all(), $id);

            return redirect()->route('membro.index')->with('success', 'Membro excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Houve um erro tentar excluir este membro');
        }
    }

    public function reintegrarMembro($id)
    {
        try {
            $data = app(IdentificaDadosReintegrarMembroService::class)->execute($id);

            $pessoa       = $data['pessoa'];
            $sugestaoRol  = $data['sugestao_rol'];
            $pastores     = $data['pastores'];
            $modos        = $data['modos'];
            $congregacoes = $data['congregacoes'];
            
            return view('membro.reintegrar_membro', compact('pessoa', 'sugestaoRol', 'pastores', 'modos', 'congregacoes'));
        } catch (ReintegrarMembroException $e) {
            return redirect()->back()->with('error', 'Membro não identificado ou é um membro excluído');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro aoabrir a página de reintegrar membro desligado');
        }
    }
}
