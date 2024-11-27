<?php

namespace App\Http\Controllers;

use App\Http\Requests\FinalizarNomeacoesRequest;
use App\Http\Requests\StoreNomeacoesClerigosRequest;
use App\Models\InstituicoesInstituicao;
use App\Models\InstituicoesTipoInstituicao;
use App\Models\PessoaFuncaoMinisterial;
use App\Models\PessoasPessoa;
use App\Services\ServiceClerigosRegiao\DeletarNomeacoesClerigos;
use App\Services\ServiceClerigosRegiao\FinalizarNomeacoesClerigos;
use App\Services\ServiceClerigosRegiao\ListaNomeacoesClerigoService;
use App\Services\ServiceNomeacoes\StoreNomeacoesClerigos;
use Illuminate\Http\Request;

class NomeacoesClerigosController extends Controller
{
    public function index($id, Request $request)
    {
        $data = app(ListaNomeacoesClerigoService::class)->execute($id, $request->input('status'));
        return view('clerigos.nomeacoes.index', $data);
    }


    public function novo(PessoasPessoa $pessoa)
    {
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

    public function store(StoreNomeacoesClerigosRequest $request)
    {

        app(StoreNomeacoesClerigos::class)->execute($request);

        return redirect()->route('clerigos.nomeacoes', ['id' => $request->pessoa_id])->with('success', 'Nomeação criada com sucesso!');
    }


    public function finalizar(string $id, FinalizarNomeacoesRequest $request)
    {

        app(FinalizarNomeacoesClerigos::class)->execute($id, $request);
        return redirect()->route('clerigos.nomeacoes.index', ['id' => $id])->with('success', 'Nomeação finalizada com sucesso!');
    }
}
