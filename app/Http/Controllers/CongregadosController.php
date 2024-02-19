<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CongregadosController extends Controller
{
    public function index() {
        return view('congregados.index');
    }

    public function novo() {
        return view('congregados.novo');
    }

    public function store(Request $request) {
        dd($request->all());
    }

    public function tornarCongregado($id) {
        return view('congregados.editar');
    }

    public function exemplo(Request $request)
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
    }
}
