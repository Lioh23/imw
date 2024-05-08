<?php

namespace App\Http\Controllers;

use App\Models\InstituicoesInstituicao;
use Illuminate\Http\Request;

class InstituicaoController extends Controller
{
    public function index(Request $request)
    {
        $query = InstituicoesInstituicao::when($request->has('search') && !empty($request->search), function($query) use ($request) {
            $query->where('nome', 'like', '%' . $request->search . '%');
        });

        $instituicoes = $query->paginate(10);
        return response()->json($instituicoes);
    }

    public function instituicoesLocais(Request $request)
    {
        $query = InstituicoesInstituicao::when($request->has('search') && !empty($request->search), function($query) use ($request) {
            $query->where('nome', 'like', '%' . $request->search . '%');
        });

        $query->where('id', session()->get('session_perfil')->instituicao_id);

        $instituicoes = $query->paginate(10);
        return response()->json($instituicoes);
    }
}
