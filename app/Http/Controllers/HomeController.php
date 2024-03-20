<?php

namespace App\Http\Controllers;

use App\Models\PerfilUser;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function selecionarInstituicao()
    {
        // Obter o ID do usuário autenticado
        $userID = Auth::id();

        // Consultar as Instituicoes dos Usuários Autenticados
        $instituicoes = PerfilUser::where('user_id', $userID)
            ->join('instituicoes_instituicoes', 'instituicoes_instituicoes.id', '=', 'perfil_user.instituicao_id')
            ->select('instituicoes_instituicoes.id', 'instituicoes_instituicoes.nome')
            ->get();

        return view('selecionarInsticuicao', ['instituicoes' => $instituicoes]);
    }

    public function postInstituicao(Request $request) {
        if ($request->has('instituicao_id')) {
                $instituicao = [
                    'id' => $request->instituicao_id,
                    'nome' => $request->instituicao_nome
                ];

            session(['session_instituicao' => $instituicao]);

            return redirect()->route('dashboard'); 
        } else {
            return redirect()->back()->with('error', 'A seleção de instituição é obrigatória. Por favor, selecione.');
        }
    }
}
