<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceInstituicaoRegiao\ListarRegiaoDistritosServices;
use Illuminate\Http\Request;

class InstituicaoRegiaoDistritosController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        $data = app(ListarRegiaoDistritosServices::class)->execute($searchTerm);

        return view('instituicoes.distritos.index', compact('data'));
    }
}
