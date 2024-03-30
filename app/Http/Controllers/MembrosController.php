<?php

namespace App\Http\Controllers;

use App\Exceptions\IdentificaDadosExcluirMembroException;
use App\Exceptions\MembroNotFoundException;
use App\Exceptions\ReceberNovoMembroException;
use App\Exceptions\ReintegrarMembroException;
use App\Http\Requests\DeletarMembroRequest;
use App\Http\Requests\StoreDisciplinarRequest;
use App\Http\Requests\StoreReceberNovoMembroRequest;
use App\Http\Requests\StoreReintegracaoRequest;
use App\Http\Requests\StoreExclusaoPorTransferenciaRequest;
use App\Http\Requests\StoreReceberMembroExternoRequest;
use App\Http\Requests\StoreTransferenciaInternaRequest;
use App\Http\Requests\UpdateDisciplinarRequest;
use App\Http\Requests\UpdateMembroRequest;
use App\Models\MembresiaMembro;
use App\Services\ServiceMembros\DeletarMembroService;
use App\Services\ServiceMembros\IdentificaDadosDisciplinaService;
use App\Services\ServiceMembros\IdentificaDadosExcluirMembroService;
use App\Services\ServiceMembros\IdentificaDadosReceberMembroExternoService;
use App\Services\ServiceMembros\IdentificaDadosReceberNovoMembroService;
use App\Services\ServiceMembros\IdentificaDadosReintegrarMembroService;
use App\Services\ServiceMembros\IdentificaDadosTransferenciaInternaService;
use App\Services\ServiceMembros\IdentificaDadosTransferenciaPorExclusaoService;
use App\Services\ServiceMembros\ListDisciplinasMembroService;
use App\Services\ServiceMembros\StoreDiciplinaService;
use App\Services\ServiceMembros\StoreExclusaoPorTransferenciaService;
use App\Services\ServiceMembros\StoreNotificacaoExclusaoPorTransferenciaService;
use App\Services\ServiceMembros\StoreReceberNovoMembroService;
use App\Services\ServiceMembros\StoreReintegracaoService;
use App\Services\ServiceMembros\StoreTransferenciaInternaService;
use App\Services\ServiceMembros\UpdateDisciplinarService;
use App\Services\ServiceMembrosGeral\EditarMembroService;
use App\Services\ServiceMembrosGeral\ListMembrosService;
use App\Services\ServiceMembrosGeral\UpdateMembroService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MembrosController extends Controller
{
    public function index(Request $request) {
        $data = app(ListMembrosService::class)->execute($request->all());
        return view('membros.index', $data);
    }
  
    public function editar($id)
    {
        try {
            $pessoa = app(EditarMembroService::class)->findOne($id);
            $disciplinas = app(ListDisciplinasMembroService::class)->execute($id);
            
            return view('membros.editar.index', [
                'pessoa'               => $pessoa['pessoa'],
                'ministerios'          => $pessoa['ministerios'],
                'funcoes'              => $pessoa['funcoes'],
                'cursos'               => $pessoa['cursos'],
                'formacoes'            => $pessoa['formacoes'],
                'funcoesEclesiasticas' => $pessoa['funcoesEclesiasticas'],
                'disciplinas'          => $disciplinas,
            ]);
        } catch(MembroNotFoundException $e) {
            return redirect()->route('membro.index')->with('error', 'Registro não encontrado.');
        } catch(\Exception $e) {
            return redirect()->route('membro.index')->with('error', 'Erro ao abrir a página, por favor, tente mais tarde!');
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

    public function exclusao($id)
    {
        try {
            $data = app(IdentificaDadosExcluirMembroService::class)->execute($id);

            $pessoa       = $data['pessoa'];
            $sugestaoRol  = $data['sugestao_rol'];
            $pastores     = $data['pastores'];
            $modos        = $data['modos'];
    
            return view('membros.exclusao', compact('pessoa', 'sugestaoRol', 'pastores', 'modos'));
        } catch(IdentificaDadosExcluirMembroException $e) {
            return redirect()->back()->with('error', 'Erro ao tentar abrir a tela de exclusão de membro');
        } catch(\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao tentar abrir a tela de exclusão de membro');
        }
    }

    public function storeExclusao(DeletarMembroRequest $request, $id)
    {
        try {
            app(DeletarMembroService::class)->execute($request->all(), $id);

            return redirect()->route('membro.index')->with('success', 'Membro excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Houve um erro tentar excluir este membro');
        }
    }

    public function reintegrar($id)
    {
        try {
            $data = app(IdentificaDadosReintegrarMembroService::class)->execute($id);

            $pessoa       = $data['pessoa'];
            $sugestaoRol  = $data['sugestao_rol'];
            $pastores     = $data['pastores'];
            $modos        = $data['modos'];
            $congregacoes = $data['congregacoes'];
            
            return view('membros.reintegrar', compact('pessoa', 'sugestaoRol', 'pastores', 'modos', 'congregacoes'));
        } catch (ReintegrarMembroException $e) {
            return redirect()->back()->with('error', 'Membro não identificado ou é um membro excluído');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao abrir a página de reintegrar membro desligado');
        }
    }

    public function storeReintegracao(StoreReintegracaoRequest $request, $id)
    {
        try {
            app(StoreReintegracaoService::class)->execute($request->all(), $id);

            return redirect()->route('membro.editar', ['id' => $id])->with('success', 'Membro reintegrado com sucesso!');
        } catch(\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao tentar reintegrar o membro');
        }
    }

    public function transferenciaInterna($id)
    {
        try {
            $data = app(IdentificaDadosTransferenciaInternaService::class)->execute($id);

            $pessoa       = $data['pessoa'];
            $congregacoes = $data['congregacoes'];
            $pastores     = $data['pastores'];

            return view('membros.transferencia_interna', compact('pessoa', 'congregacoes', 'pastores'));
        } catch(\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao abrir a página de Transferência Interna');
        }
    }

    public function storeTransferenciaInterna(StoreTransferenciaInternaRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            app(StoreTransferenciaInternaService::class)->execute($request->all(), $id);
            DB::commit();
            return(redirect()->route('membro.editar', ['id'=> $id])->with('success', 'Transferência Interna realizada com sucesso.'));
        } catch(\Exception $e) {
            DB::rollback();
            return(redirect()->route('membro.transferencia_interna', ['id'=> $id])->with('error', 'Erro ao realizar a tranferência interna.'));
        }
    }

    public function exclusaoPorTransferencia($id)
    {
        try {
            $data = app(IdentificaDadosTransferenciaPorExclusaoService::class)->execute($id);

            return view('membros.exclusao_transferencia', $data);
        } catch(\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao abrir a página de Transferência Por Exclusão');
        }
    }

    public function storeExclusaoPorTransferencia(StoreExclusaoPorTransferenciaRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            app(StoreNotificacaoExclusaoPorTransferenciaService::class)->execute($request->all(), $id);
            DB::commit();
            return redirect()->route('membro.editar', ['id' => $id])->with('success', 'Exclusão por transferência registrada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('membro.exclusao_transferencia', ['id' => $id])->with('error', 'Erro ao registrar a transferência.');
        }
    }

    public function disciplinar($id)
    {
        try {
            $data = app(IdentificaDadosDisciplinaService::class)->execute($id);

            $pessoa   = $data['pessoa'];
            $pastores = $data['pastores'];
            $modos    = $data['modos'];

            return view('membros.disciplinar', compact('pessoa', 'pastores', 'modos'));
        } catch(\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao abrir a página de Disciplinar');
        }
    }

    public function storeDisciplinar(StoreDisciplinarRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            app(StoreDiciplinaService::class)->execute($request->all(), $id);
            DB::commit();
            return(redirect()->route('membro.editar', ['id'=> $id])->with('success', 'Membro diciplinado com sucesso.'));
        } catch(\Exception $e) {
            DB::rollback();
            return(redirect()->route('membro.editar', ['id'=> $id])->with('error', 'Falha ao diciplinar o membro.'));
        }
    }

    public function updateDisciplinar(UpdateDisciplinarRequest $request, $id)
    {
        try{
            DB::beginTransaction();
            app(UpdateDisciplinarService::class)->execute($request->get('dt_termino'), $id);
            DB::commit();
            return response()->json(['message' => 'Disciplina atualizada com sucesso!']);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ao atualizar a disciplina deste membro!']);
        }
    }

    public function receberMembroExterno($id)
    {
        try {
            $data = app(IdentificaDadosReceberMembroExternoService::class)->execute($id);

            return view('membros.receber_membro_externo', $data);
        } catch(\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao abrir a página de recebimento de membro externo');
        }
    }

    public function storeReceberMembroExterno(StoreReceberMembroExternoRequest $request, $id)
    {
        
    }
}
