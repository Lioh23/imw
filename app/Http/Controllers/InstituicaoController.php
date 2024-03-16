<?php

namespace App\Http\Controllers;

use App\Models\InstituicoesInstituicao;
use Illuminate\Http\Request;

class InstituicaoController extends Controller
{
    public function index(Request $request)
    {
        $instituicoes = InstituicoesInstituicao::paginate(10); 
        return response()->json($instituicoes);
    }
}
