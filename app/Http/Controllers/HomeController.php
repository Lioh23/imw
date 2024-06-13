<?php

namespace App\Http\Controllers;

use App\Models\MembresiaMembro;
use App\Models\PerfilUser;
use App\Services\ServicePerfil\IdentificaPerfilService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function dashboard()
    {
        $igrejaId = session()->get('session_perfil')->instituicao_id;
        $statusAtivo = 'A';
        $statusInativo = 'I';

        $activeMembrosCount = MembresiaMembro::join('membresia_rolpermanente as mr', 'membresia_membros.id', '=', 'mr.membro_id')
        ->where('membresia_membros.vinculo', 'M')
        ->where('membresia_membros.igreja_id', $igrejaId)
        ->where('mr.status', 'A')
        ->where('mr.lastrec', 1)
        ->count();

        $activeCongregadosCount =  MembresiaMembro::where('membresia_membros.vinculo', 'C')
            ->where('membresia_membros.igreja_id', $igrejaId)
            ->count();

        
        $activeVisitantesCount = DB::table('membresia_membros as mm')
            ->where('mm.vinculo', 'V')
            ->where('mm.igreja_id', $igrejaId)
            ->count();

        $totalAtivos = DB::table('membresia_membros as mm')
            ->join('membresia_rolpermanente as mr', 'mm.id', '=', 'mr.membro_id')
            ->where('mm.vinculo', 'M')
            ->where('mm.igreja_id', $igrejaId)
            ->where('mr.status', 'A')
            ->count();


        $totalInativos = DB::table('membresia_membros as mm')
            ->join('membresia_rolpermanente as mr', 'mm.id', '=', 'mr.membro_id')
            ->where('mm.vinculo', 'M')
            ->where('mm.igreja_id', $igrejaId)
            ->where('mr.status', 'I')
            ->count();

        $visitantesPorMes = MembresiaMembro::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('vinculo', 'V')
            ->where('status', $statusAtivo)
            ->where('igreja_id', $igrejaId)
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get()
            ->pluck('count', 'month')
            ->toArray();
    
     
        $visitantesPorMesCompleto = array_fill(1, 12, 0);
        foreach ($visitantesPorMes as $month => $count) {
            $visitantesPorMesCompleto[$month] = $count;
        }

        return view('dashboard', [
            'activeMembrosCount' => $activeMembrosCount,
            'activeCongregadosCount' => $activeCongregadosCount,
            'activeVisitantesCount' => $activeVisitantesCount,
            'totalAtivos' => $totalAtivos,
            'totalInativos' => $totalInativos,
            'visitantesPorMes' => $visitantesPorMesCompleto,
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
