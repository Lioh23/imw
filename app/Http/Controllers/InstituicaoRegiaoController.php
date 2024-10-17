<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReceberNovoRequest;
use App\Models\InstituicoesInstituicao;
use App\Models\InstituicoesTipoInstituicao;
use App\Services\ServiceInstituicaoRegiao\UpdateRegiaoService;
use App\Services\ServiceInstituicaoRegiao\ListarRegiaoServices;
use App\Services\ServiceInstituicaoRegiao\DeletarRegiaoService;
use App\Services\ServiceInstituicaoRegiao\AtivarRegiaoService;
use App\Services\ServiceInstituicaoRegiao\DetalhesRegiaoService;
use App\Services\ServiceInstituicaoRegiao\StoreRegiaoService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Svg\Tag\Rect;

class InstituicaoRegiaoController extends Controller
{
    public function index(Request $request)
    {
        $tipoInstituicaoId = $request->get('tipo_instituicao_id');

        $searchTerm = $request->input('search');
        $instituicoes = app(ListarRegiaoServices::class)->execute($searchTerm, $tipoInstituicaoId);

        return view('instituicoes.index', compact('instituicoes'));
    }


    public function novo()
    {
        //Enviar Lista de insituicões pai, todas da regiao_id exceto igrejas
        $instituicoes_pai = InstituicoesInstituicao::where('regiao_id', session()->get('session_perfil')->instituicao_id)->where('tipo_instituicao_id', '!=', 1)->get();
        return view('instituicoes.novo', compact('instituicoes_pai'));
    }

    public function store(StoreReceberNovoRequest $request)
    {
        app(StoreRegiaoService::class)->execute($request);

        return redirect()->route('instituicoes.index')->with('success', 'Instituição criado com sucesso!');
    }

    public function editar(string $id)
    {
        //Enviar Lista de insituicões pai, todas da regiao_id exceto igrejas
        $instituicoes_pai = InstituicoesInstituicao::where('regiao_id', session()->get('session_perfil')->instituicao_id)->where('tipo_instituicao_id', '!=', 1)->get();
        $instituicao = InstituicoesInstituicao::findOrFail($id);
       
        return view('instituicoes.editar', compact('instituicao', 'instituicoes_pai' ));
    }


    public function update(StoreReceberNovoRequest $request, string $id)
    {
      
       
        app(UpdateRegiaoService::class)->execute($request, $id);

        return redirect()->route('instituicoes.index')->with('success', 'Instituição editado com sucesso!');
    }



    public function deletar($id)
    {
        app(DeletarRegiaoService::class)->execute($id);

        return redirect()->route('instituicoes.index')->with('success', 'Instituição inativado com sucesso.');
    }

    public function ativar($id)
    {
        app(AtivarRegiaoService::class)->execute($id);

        return redirect()->route('instituicoes.index')->with('success', 'Instituição ativado com sucesso.');
    }

    public function detalhes($id)
    {
        $instituicao = app(DetalhesRegiaoService::class)->execute($id);
        return response()->json($instituicao);
    }
}
