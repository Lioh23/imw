<?php

namespace App\Http\Controllers;

use App\Exceptions\MembroNotFoundException;
use App\Http\Requests\StoreCongregadoRequest;
use App\Services\ServicesCongregados\ListCongregadosService;
use App\Services\ServicesCongregados\TornarCongregadoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CongregadosController extends Controller
{
    public function index(Request $request) {
        $congregados = app(ListCongregadosService::class)->execute($request->get('search'));
        return view('congregados.index', compact('congregados'));
    }

    public function novo() {
        return view('congregados.novo');
    }

    public function store(StoreCongregadoRequest $request)
    {
       try {
            DB::beginTransaction();
            app(TornarCongregadoService::class)->execute($request->all());
            DB::commit();
            return redirect()->action([CongregadosController::class, 'tornarCongregado'], ['id' => $request->input('membro_id')])->with('success', 'Registro atualizado.');
        } catch(\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->action([CongregadosController::class, 'tornarCongregado'], ['id' => $request->input('membro_id')])->with('error', 'Falha ao atualizar os dados.');
       
        }
    }

    public function tornarCongregado($id) {
        
        try {
            $pessoa = app(TornarCongregadoService::class)->findOne($id);
            
            return view('congregados.editar', [
                'pessoa'               => $pessoa['pessoa'],
                'ministerios'          => $pessoa['ministerios'],
                'funcoes'              => $pessoa['funcoes'],
                'cursos'               => $pessoa['cursos'],
                'formacoes'            => $pessoa['formacoes'],
                'funcoesEclesiasticas' => $pessoa['funcoesEclesiasticas'],
            ]);
        } catch(MembroNotFoundException $e) {
            return redirect()->route('visitante.index')->with('error', 'Visitante não encontrado.');
        } catch(\Exception $e) {
            return redirect()->route('visitante.index')->with('error', 'Erro ao abrir a página, por favor, tente mais tarde!');
        }
    }

    public function editar($id)
    {
        # TODO
    }

    public function deletar($id)
    {
        # TODO
    }

    /*  public function salvar(Request $request)
    {
        $request->validate([
            // Validações básicas para os campos do formulário
            'nome' => 'required|string|max:255',
            // Adicione mais validações conforme necessário
        ]);

        // Salvando informações básicas do membro
        $membro = new Membro();
        $membro->nome = $request->nome;
        $membro->cpf = $request->cpf;
        // Adicione mais campos conforme necessário
        $membro->save();

        // Salvando informações ministeriais
        if($request->has('ministerial-departamento')) {
            foreach($request->input('ministerial-departamento') as $key => $value) {
                $ministerio = new Ministerio();
                $ministerio->membro_id = $membro->id;
                $ministerio->departamento = $value;
                $ministerio->funcao = $request->ministerial-funcao[$key];
                // Adicione mais campos conforme necessário
                $ministerio->save();
            }
        }

        // Salvando informações de formação
        if($request->has('curso-nome')) {
            foreach($request->input('curso-nome') as $key => $value) {
                $formacao = new Formacao();
                $formacao->membro_id = $membro->id;
                $formacao->curso = $value;
                $formacao->inicio = $request->curso-data-inicio[$key];
                $formacao->conclusao = $request->curso-data-conclusao[$key];
                // Adicione mais campos conforme necessário
                $formacao->save();
            }
        }

        // Redirecionar após a criação
        return redirect()->route('alguma.rota.de.sucesso')->with('success', 'Membro criado com sucesso!');
    } */
}
