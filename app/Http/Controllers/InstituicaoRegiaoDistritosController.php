<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReceberNovoRequest;
use App\Models\InstituicoesInstituicao;
use App\Services\ServiceInstituicaoRegiao\UpdateRegiaoService;
use App\Services\ServiceInstituicaoRegiao\ListarRegiaoServices;
use App\Services\ServiceInstituicaoRegiao\DeletarRegiaoService;
use App\Services\ServiceInstituicaoRegiao\AtivarRegiaoService;
use App\Services\ServiceInstituicaoRegiao\DetalhesRegiaoService;
use App\Services\ServiceInstituicaoRegiao\StoreRegiaoService;
use App\Traits\LocationUtils;
use Illuminate\Http\Request;

class InstituicaoRegiaoDistritosController extends Controller
{
    use LocationUtils;
    public function index(Request $request)
    {
        $tipoInstituicaoId = $request->get('tipo_instituicao_id');
        $searchTerm = $request->input('search');
        $parameters = ['search' => $searchTerm]; // Montando um array para os parâmetros
        $instituicoes = app(ListarRegiaoServices::class)->execute($parameters, $tipoInstituicaoId);

        return view('instituicoes.index', compact('instituicoes'));
    }


    public function novo()
    {
        //Enviar Lista de insituicões pai, todas da regiao_id exceto igrejas
        $ufs = $this->fetchUFs();
        $instituicoes_pai = InstituicoesInstituicao::select('instituicoes_instituicoes.*', 'ii_pai.nome as instituicao_pai_nome') // Selecionando apenas os nomes
            ->where(function ($query) {
                $query->where('instituicoes_instituicoes.tipo_instituicao_id', 3);
            })
            ->orWhere(function ($query) {
                $query->where('instituicoes_instituicoes.regiao_id', session()->get('session_perfil')->instituicao_id)
                    ->where('instituicoes_instituicoes.tipo_instituicao_id', '!=', 1);
            })
            ->join('instituicoes_instituicoes as ii_pai', 'ii_pai.id', '=', 'instituicoes_instituicoes.instituicao_pai_id') // Realiza o JOIN
            ->get();

        return view('instituicoes.novo', compact('instituicoes_pai', 'ufs'));
    }

    public function store(StoreReceberNovoRequest $request)
    {

        app(StoreRegiaoService::class)->execute($request);

        return redirect()->route('instituicoes-regiao.index')->with('success', 'Instituição criado com sucesso!');
    }

    public function editar(string $id)
    {
        //Enviar Lista de insituicões pai, todas da regiao_id exceto igrejas
        $instituicoes_pai = InstituicoesInstituicao::select('instituicoes_instituicoes.*', 'ii_pai.nome as instituicao_pai_nome') // Selecionando apenas os nomes
            ->where(function ($query) {
                $query->where('instituicoes_instituicoes.tipo_instituicao_id', 3);
            })
            ->orWhere(function ($query) {
                $query->where('instituicoes_instituicoes.regiao_id', session()->get('session_perfil')->instituicao_id)
                    ->where('instituicoes_instituicoes.tipo_instituicao_id', '!=', 1);
            })
            ->join('instituicoes_instituicoes as ii_pai', 'ii_pai.id', '=', 'instituicoes_instituicoes.instituicao_pai_id') // Realiza o JOIN
            ->get();

        $instituicao = InstituicoesInstituicao::findOrFail($id);
        $ufs = $this->fetchUFs();
        return view('instituicoes.editar', compact('instituicao', 'instituicoes_pai', 'ufs'));
    }


    public function update(StoreReceberNovoRequest $request, string $id)
    {

        app(UpdateRegiaoService::class)->execute($request, $id);

        return redirect()->route('instituicoes-regiao.index')->with('success', 'Instituição editado com sucesso!');
    }



    public function deletar($id, Request $request)
    {
        $searchTerm = $request->input('search');
        // Lógica para inativar a instituição
        app(DeletarRegiaoService::class)->execute($id);

        return redirect()->route('instituicoes-regiao.index', ['search' => $searchTerm])->with('success', 'Instituição inativada com sucesso.');
    }

    public function ativar($id, Request $request)
    {
        $searchTerm = $request->input('search');
        // Lógica para ativar a instituição
        app(AtivarRegiaoService::class)->execute($id);

        return redirect()->route('instituicoes-regiao.index', ['search' => $searchTerm])->with('success', 'Instituição ativada com sucesso.');
    }

    public function detalhes($id)
    {
        $instituicao = app(DetalhesRegiaoService::class)->execute($id);
        return response()->json($instituicao);
    }
}
