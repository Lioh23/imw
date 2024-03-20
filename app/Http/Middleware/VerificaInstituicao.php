<?php

namespace App\Http\Middleware;

use App\Models\PerfilUser;
use Closure;
use Illuminate\Http\Request;

class VerificaInstituicao
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // Verifica se a session 'instituicao' não existe
        if (!session()->has('session_instituicao')) {
            $user = auth()->user();

            // Obtém a contagem de instituicoes vinculadas ao usuário
          
            $countInstituicoes = PerfilUser::where('user_id', $user->id)->count();

            // Se o usuário está vinculado a apenas uma instituicao
            if ($countInstituicoes == 1) {
                $instituicao = PerfilUser::where('user_id', $user->id)
                    ->join('instituicoes_instituicoes', 'instituicoes_instituicoes.id', '=', 'perfil_user.instituicao_id')
                    ->select('instituicoes_instituicoes.id', 'instituicoes_instituicoes.nome')
                    ->first();
                
                $instituicao = [
                    'id' => $instituicao->id, 
                    'nome' => $instituicao->nome
                ];

                dd($instituicao);
                session([
                    'session_instituicao' => $instituicao
                ]);

            } else {
                // Se o usuário estiver vinculado a mais de uma redireciona para selecionarInstituicao
                return redirect('selecionarInstituicao');
            }
        }

        return $next($request);
    }
}
