<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceInstituicaoIgrejas\ListarIgrejasDistritosServices;
use Illuminate\Http\Request;

class InstituicaoRegiaoIgrejasController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        $igrejas = app(ListarIgrejasDistritosServices::class)->execute($searchTerm);
        return view('instituicoes.igrejas.index', compact('igrejas'));
    }
}
