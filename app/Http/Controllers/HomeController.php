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

    public function selecionarPerfil()
    {
        // Obter o ID do usuário autenticado
        $userID = Auth::id();

        // Consultar as Instituicoes dos Usuários Autenticados
        $perfils = PerfilUser::where('user_id', $userID)
            ->join('instituicoes_instituicoes', 'instituicoes_instituicoes.id', '=', 'perfil_user.instituicao_id')
            ->join('perfils', 'perfils.id', '=', 'perfil_user.perfil_id')
            ->select('instituicoes_instituicoes.instituicao_id', 'instituicoes_instituicoes.instituicao_nome', 'perfils.id as perfil_id', 'perfils.nome as perfil')
            ->get();

        return view('selecionarPerfil', ['perfils' => $perfils]);
    }

    public function postPerfil(Request $request) {
        if ($request->has('instituicao_id')) {
                $instituicao = [
                    'id' => $request->instituicao_id,
                    'nome' => $request->instituicao_nome
                ];

            session(['session_perfil' => $instituicao]);

            return redirect()->route('dashboard'); 
        } else {
            return redirect()->back()->with('error', 'A seleção de instituição é obrigatória. Por favor, selecione.');
        }
    }
}
