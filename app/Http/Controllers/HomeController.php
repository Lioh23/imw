<?php

namespace App\Http\Controllers;

use App\Models\MembresiaMembro;
use App\Models\PerfilUser;
use App\Services\ServicePerfil\IdentificaPerfilService;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
        $igrejaId = session()->get('session_perfil')->instituicao_id;
        $statusAtivo = 'A';
    
        $counts = MembresiaMembro::selectRaw("
                SUM(CASE WHEN vinculo = 'M' THEN 1 ELSE 0 END) as activeMembrosCount,
                SUM(CASE WHEN vinculo = 'C' THEN 1 ELSE 0 END) as activeCongregadosCount,
                SUM(CASE WHEN vinculo = 'V' THEN 1 ELSE 0 END) as activeVisitantesCount
            ")
            ->where('status', $statusAtivo)
            ->where('igreja_id', $igrejaId)
            ->first();
    
        return view('dashboard', [
            'activeMembrosCount' => $counts->activeMembrosCount,
            'activeCongregadosCount' => $counts->activeCongregadosCount,
            'activeVisitantesCount' => $counts->activeVisitantesCount,
        ]);
    }
    
    public function selecionarPerfil()
    {
        // Obter o ID do usuário autenticado
        $userID = Auth::id();

        // Consultar as Instituicoes dos Usuários Autenticados
        $perfils = PerfilUser::where('user_id', $userID)
            ->join('instituicoes_instituicoes', 'instituicoes_instituicoes.id', '=', 'perfil_user.instituicao_id')
            ->join('perfils', 'perfils.id', '=', 'perfil_user.perfil_id')
            ->select(
                'instituicoes_instituicoes.id as instituicao_id',
                'instituicoes_instituicoes.nome as instituicao_nome',
                'perfils.id as perfil_id',
                'perfils.nome as perfil_nome'
            )
            ->get();

        return view('selecionarPerfil', ['perfils' => $perfils]);
    }

    public function postPerfil(Request $request)
    {
        if ($request->has('instituicao_id')) {

            $perfil = app(IdentificaPerfilService::class)->execute(
                $request->instituicao_id,
                $request->instituicao_nome,
                $request->perfil_id,
                $request->perfil_nome,
            );

            session(['session_perfil' => $perfil]);

            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->with('error', 'A seleção de um perfil é obrigatória. Por favor, selecione.');
        }
    }
}
