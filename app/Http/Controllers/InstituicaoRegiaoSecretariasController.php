<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReceberNovaSecretariaRequest;
use App\Models\InstituicoesInstituicao;
use App\Services\ServiceInstituicaoSecretarias\AtivarRegiaoSecretariasService;
use App\Services\ServiceInstituicaoSecretarias\DeletarRegiaoSecretariasService;
use App\Services\ServiceInstituicaoSecretarias\DetalhesRegiaoSecretariasService;
use App\Services\ServiceInstituicaoSecretarias\ListarRegiaoSecretariasServices;
use App\Services\ServiceInstituicaoSecretarias\StoreRegiaoSecretariasService;
use App\Services\ServiceInstituicaoSecretarias\UpdateRegiaoSecretariasService;
use Illuminate\Http\Request;

class InstituicaoRegiaoSecretariasController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        $secretarias = app(ListarRegiaoSecretariasServices::class)->execute($searchTerm);
        return view('instituicoes.secretarias.index', compact('secretarias'));
    }
    public function novo()
    {
        $instituicao_pai_id = InstituicoesInstituicao::query()->when(true, function ($query) {
            $query->where('tipo_instituicao_id', 5)
                ->orWhere('tipo_instituicao_id', 9);
        })->get();

        return view('instituicoes.secretarias.novo', compact('instituicao_pai_id'));
    }
    public function editar($id)
    {
        $instituicao_pai_id = InstituicoesInstituicao::query()->when(true, function ($query) {
            $query->where('tipo_instituicao_id', 5)
                ->orWhere('tipo_instituicao_id', 9);
        })->get();
        $distrito = InstituicoesInstituicao::findOrFail($id);
        return view('instituicoes.secretarias.editar', compact('distrito', 'instituicao_pai_id'));
    }
    public function store(StoreReceberNovaSecretariaRequest $request)
    {
        app(StoreRegiaoSecretariasService::class)->execute($request);

        return redirect()->route('instituicoes.secretarias.index')->with('success', 'Secretaria criada com sucesso!');
    }
    public function update(StoreReceberNovaSecretariaRequest $request, string $id)
    {
        app(UpdateRegiaoSecretariasService::class)->execute($request, $id);

        return redirect()->route('instituicoes.secretarias.index')->with('success', 'Secretaria editad1 com sucesso!');
    }



    public function deletar($id)
    {
        app(DeletarRegiaoSecretariasService::class)->execute($id);

        return redirect()->route('instituicoes.secretarias.index')->with('success', 'Secretaria inativado com sucesso.');
    }

    public function ativar($id)
    {
        app(AtivarRegiaoSecretariasService::class)->execute($id);

        return redirect()->route('instituicoes.secretarias.index')->with('success', 'Secretaria ativado com sucesso.');
    }

    public function detalhes($id)
    {
        $secretaria = app(DetalhesRegiaoSecretariasService::class)->execute($id);
        return response()->json($secretaria);
    }
}
