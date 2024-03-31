<?php

namespace App\Http\Controllers;

use App\Models\InstituicoesInstituicao;
use Illuminate\Http\Request;

class InstituicaoController extends Controller
{
    public function index(Request $request)
    {
        $query = InstituicoesInstituicao::where(function ($query) {
            $query->where('id', session()->get('session_perfil')->instituicao_id)
                  ->orWhere('instituicao_pai_id', session()->get('session_perfil')->instituicao_id);
        });

        if ($request->has('search') && !empty($request->search)) {
            $query->where('nome', 'like', '%' . $request->search . '%');
        }
    
        $instituicoes = $query->paginate(10);
        return response()->json($instituicoes);
    }
}
