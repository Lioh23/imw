<?php

namespace App\Http\Controllers;

use App\Exceptions\MembroNotFoundException;
use App\Http\Requests\StoreCongregadoRequest;
use App\Services\ServicesCongregados\TornarCongregadoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CongregadosController extends Controller
{
    public function index() {
        return view('congregados.index');
    }

    public function novo() {
        return view('congregados.novo');
    }

    public function store(StoreCongregadoRequest $request)
    {
       dd($request->all());
       try {
            DB::beginTransaction();
            app(TornarCongregadoService::class)->execute($request->all());
            DB::commit();
            return redirect()->route('visitante.novo')->with('success', 'Visitante cadastrado com sucesso.');
        } catch(\Exception $e) {
            DB::rollback();
            return redirect()->route('visitante.novo')->with('error', 'Falha ao cadastrar o visitante.');
       }
    }

    public function tornarCongregado($id) {
        
        try {
            $pessoa = app(TornarCongregadoService::class)->findOne($id);
            
            return view('congregados.editar', [
                'pessoa'      => $pessoa['pessoa'],
                'ministerios' => $pessoa['ministerios'],
                'funcoes'     => $pessoa['funcoes'],
                'cursos'      => $pessoa['cursos']
            ]);
        } catch(MembroNotFoundException $e) {
            return redirect()->route('visitante.index')->with('error', 'Visitante não encontrado.');
        } catch(\Exception $e) {
            return redirect()->route('visitante.index')->with('error', 'Erro ao abrir a página, por favor, tente mais tarde!');
        }
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
