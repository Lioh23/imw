<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAccessControl
{
    public function handle(Request $request, Closure $next, $regraNome)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Acesso não autorizado');
        }
        
        if (!$user->hasPerfilRegra($regraNome)) {
            abort(403, 'Acesso não autorizado');
        }

        return $next($request);
    }
}
