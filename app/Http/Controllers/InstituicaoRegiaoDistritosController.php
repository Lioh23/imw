<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceInstituicaoRegiao\ListarRegiaoDistritosServices;
use App\Services\ServiceInstituicaoRegiao\DeletarRegiaoDistritosService;
use App\Services\ServiceInstituicaoRegiao\AtivarRegiaoDistritosService;
use App\Services\ServiceInstituicaoRegiao\DetalhesRegiaoDistritosService;
use Illuminate\Http\Request;

class InstituicaoRegiaoDistritosController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        $distritos = app(ListarRegiaoDistritosServices::class)->execute($searchTerm);
        return view('instituicoes.distritos.index', compact('distritos'));
    }

    public function deletar($id)
    {
        app(DeletarRegiaoDistritosService::class)->execute($id);

        return redirect()->route('instituicoes.distritos.index')->with('success', 'Distrito inativado com sucesso.');
    }

    public function ativar($id)
    {
        app(AtivarRegiaoDistritosService::class)->execute($id);

        return redirect()->route('instituicoes.distritos.index')->with('success', 'Distrito ativado com sucesso.');
    }

    public function detalhes($id)
    {
        $distrito = app(DetalhesRegiaoDistritosService::class)->execute($id);
        return response()->json($distrito);
    }
}
