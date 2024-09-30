<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReceberNovoDistritoRequest;
use App\Models\InstituicoesInstituicao;
use App\Services\ServiceInstituicaoRegiao\UpdateRegiaoDistritosService;
use App\Services\ServiceInstituicaoRegiao\ListarRegiaoDistritosServices;
use App\Services\ServiceInstituicaoRegiao\DeletarRegiaoDistritosService;
use App\Services\ServiceInstituicaoRegiao\AtivarRegiaoDistritosService;
use App\Services\ServiceInstituicaoRegiao\DetalhesRegiaoDistritosService;
use App\Services\ServiceInstituicaoRegiao\StoreRegiaoDistritosService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Svg\Tag\Rect;

class InstituicaoRegiaoDistritosController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        $distritos = app(ListarRegiaoDistritosServices::class)->execute($searchTerm);
        return view('instituicoes.distritos.index', compact('distritos'));
    }


    public function novo()
    {
        return view('instituicoes.distritos.novo');
    }

    public function store(StoreReceberNovoDistritoRequest $request)
    {
        app(StoreRegiaoDistritosService::class)->execute($request);

        return redirect()->route('instituicoes.distritos.index')->with('success', 'Distrito criado com sucesso!');
    }

    public function editar($id)
    {
        $distrito = InstituicoesInstituicao::findOrFail($id);
        return view('instituicoes.distritos.editar', compact('distrito'));
    }


    public function update(StoreReceberNovoDistritoRequest $request, string $id)
    {
        dd($request->all());
        app(UpdateRegiaoDistritosService::class)->execute($request, $id);

        return redirect()->route('instituicoes.distritos.index')->with('success', 'Distrito editado com sucesso!');
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
