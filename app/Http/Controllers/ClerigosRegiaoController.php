<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNomeacoesClerigosRequest;
use App\Models\Formacao;
use Illuminate\Http\Request;
use App\Models\PessoasPessoa;
use App\Traits\LocationUtils;
use App\Http\Requests\StoreReceberNovoClerigoRequest;
use App\Models\InstituicoesInstituicao;
use App\Models\InstituicoesTipoInstituicao;
use App\Models\PessoaFuncaoMinisterial;
use App\Services\ServiceClerigosRegiao\AtivarClerigoService;
use App\Services\ServiceClerigosRegiao\ListaClerigosService;
use App\Services\ServiceClerigosRegiao\StoreClerigosService;
use App\Services\ServiceClerigosRegiao\DeletarClerigoService;
use App\Services\ServiceClerigosRegiao\UpdateClerigosService;
use App\Services\ServiceClerigosRegiao\DetalhesClerigoService;
use App\Services\ServiceClerigosRegiao\ListaNomeacoesClerigoService;
use App\Services\ServiceNomeacoes\StoreNomeacoesClerigos;

class ClerigosRegiaoController extends Controller
{

    use LocationUtils;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        $clerigos = app(ListaClerigosService::class)->execute($searchTerm);

        return view('clerigos.index', compact('clerigos'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function novo()
    {
        $formacoes =  Formacao::all();
        $ufs = $this->fetchUFs();

        return view('clerigos.novo.index', compact('ufs', 'formacoes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReceberNovoClerigoRequest $request)
    {

        app(StoreClerigosService::class)->execute($request);

        return redirect()->route('clerigos.index')->with('success', 'Clerigo criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {
        $formacoes =  Formacao::all();
        $ufs = $this->fetchUFs();
        $clerigo = PessoasPessoa::findOrfail($id);
        return view('clerigos.editar.index', compact('clerigo', 'ufs', 'formacoes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreReceberNovoClerigoRequest $request, $id)
    {

        app(UpdateClerigosService::class)->execute($request, $id);

        return redirect()->route('clerigos.index')->with('sucess', 'Clerigo editado com sucesso!');
    }

    public function deletar($id)
    {
        app(DeletarClerigoService::class)->execute($id);

        return redirect()->route('clerigos.index')->with('success', 'Clerigo inativado com sucesso.');
    }

    public function ativar($id)
    {
        app(AtivarClerigoService::class)->execute($id);

        return redirect()->route('clerigos.index')->with('success', 'Clerigo ativado com sucesso.');
    }

    public function detalhes($id)
    {
        $clerigos = app(DetalhesClerigoService::class)->execute($id);

        return response()->json($clerigos);
    }

    public function nomeacoes($id, Request $request)
    {
        $data = app(ListaNomeacoesClerigoService::class)->execute($id, $request->input('status'));
        return view('clerigos.nomeacoes.index', $data);
    }


    public function novaNomeacao(PessoasPessoa $pessoa){
        $id = $pessoa->id;
        $instituicoes_completa = [];
        $instituicoes = InstituicoesInstituicao::whereIn('tipo_instituicao_id', [
                InstituicoesTipoInstituicao::IGREJA_LOCAL, 
                InstituicoesTipoInstituicao::DISTRITO, 
                InstituicoesTipoInstituicao::REGIAO, 
                InstituicoesTipoInstituicao::SECRETARIA, 
                InstituicoesTipoInstituicao::SECRETARIA_REGIONAL, 
            ])
            ->orderBy('nome')
            ->get();

        $funcoes = PessoaFuncaoMinisterial::orderBy('funcao')->get();

        return view('clerigos.nomeacoes.novo', compact('instituicoes', 'id', 'funcoes', 'pessoa'));
    }

    public function storeNomeacao(StoreNomeacoesClerigosRequest $request){

        app(StoreNomeacoesClerigos::class)->execute($request);

        return redirect()->route('clerigos.nomeacoes', ['id' => $request->pessoa_id])->with('success', 'Nomeação criada com sucesso!');
    }
}
