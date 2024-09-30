<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReceberNovaIgrejaRequest;
use App\Models\InstituicoesInstituicao;
use App\Services\ServiceInstituicaoIgrejas\StoreRegiaoIgrejasService;
use App\Services\ServiceInstituicaoIgrejas\ListarRegiaoIgrejasServices;
use App\Services\ServiceInstituicaoIgrejas\AtivarRegiaoIgrejasService;
use App\Services\ServiceInstituicaoIgrejas\DeletarRegiaoIgrejasService;
use App\Services\ServiceInstituicaoIgrejas\DetalhesRegiaoIgrejasService;
use App\Services\ServiceInstituicaoIgrejas\UpdateRegiaoIgrejasService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InstituicaoRegiaoIgrejasController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        $igrejas = app(ListarRegiaoIgrejasServices::class)->execute($searchTerm);
        return view('instituicoes.igrejas.index', compact('igrejas'));
    }
    public function novo()
    {
        $instituicao_pai_id = InstituicoesInstituicao::query()->when(true, function ($query) {
            $query->where('tipo_instituicao_id', 2);
        })->get();

        return view('instituicoes.igrejas.novo', compact('instituicao_pai_id'));
    }
    public function editar($id)
    {
        $instituicao_pai_id = InstituicoesInstituicao::query()->when(true, function ($query) {
            $query->where('tipo_instituicao_id', 2);
        })->get();
        $igreja = InstituicoesInstituicao::findOrFail($id);
        return view('instituicoes.igrejas.editar', compact('igreja' ,'instituicao_pai_id'));
    }
    public function store(StoreReceberNovaIgrejaRequest $request)
    {
        app(StoreRegiaoIgrejasService::class)->execute($request);

        return redirect()->route('instituicoes.igrejas.index')->with('success', 'Igreja criada com sucesso!');
    }

    public function update(StoreReceberNovaIgrejaRequest $request, string $id)
    {
        app(UpdateRegiaoIgrejasService::class)->execute($request, $id);

        return redirect()->route('instituicoes.igrejas.index')->with('success', 'Igreja editada com sucesso!');
    }



    public function deletar($id)
    {
        app(DeletarRegiaoIgrejasService::class)->execute($id);

        return redirect()->route('instituicoes.igrejas.index')->with('success', 'Igreja inativada com sucesso.');
    }

    public function ativar($id)
    {
        app(AtivarRegiaoIgrejasService::class)->execute($id);

        return redirect()->route('instituicoes.igrejas.index')->with('success', 'Igreja ativada com sucesso.');
    }

    public function detalhes($id)
    {
        $igreja = app(DetalhesRegiaoIgrejasService::class)->execute($id);
        return response()->json($igreja);
    }
}
