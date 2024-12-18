<?php

namespace App\Http\Controllers;

use App\Models\PessoaFuncaoMinisterial;
use App\Models\PessoaNomeacao;
use App\Models\PessoasPessoa;
use App\Models\PessoasPrebenda;
use App\Models\Prebenda;
use App\Services\ServiceClerigosPrebendas\StorePrebendasClerigosService;
use App\Services\ServiceClerigosPrebendas\UpdateFuncaoMinisterialClerigosService;
use App\Services\ServiceClerigosPrebendas\UpdatePrebendaClerigosService;
use Illuminate\Http\Request;

class PrebendasClerigosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $funcoes = PessoaFuncaoMinisterial::orderBy('ordem', 'desc')->get();

        $prebendas = Prebenda::where('ativo', 1)->orderBy('ano', 'asc')->get();
        return view('prebendas.index', [
            'funcoes' => $funcoes,
            'prebendas' => $prebendas,
        ]);
    }

    public function getValor(Request $request)
    {
        $ano = $request->input('ano');
        $prebenda = Prebenda::where('ano', $ano)->where('ativo', 1)->first();
        $funcoes = PessoaFuncaoMinisterial::orderBy('ordem', 'desc')->get();

        if ($prebenda) {
            $valorPrebenda = $prebenda->valor;
        } else {
            $valorPrebenda = 0;
        }
        foreach ($funcoes as $funcao) {
            $funcao->valor_calculado = $valorPrebenda * $funcao->qtd_prebendas;
        }

        if ($prebenda) {
            return response()->json(['valor' => $prebenda->valor]);
        }

        return response()->json(['error' => 'Prebenda não encontrada'], 404);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $prebendas = Prebenda::all();
        $pessoa = PessoasPessoa::findOrFail($id);
        return view('prebendas.novo', ['prebendas' => $prebendas, 'pessoa' => $pessoa]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        app(StorePrebendasClerigosService::class)->execute($request);
        return redirect()->route('clerigos.prebendas.index')->with('success', 'Prebenda criada com sucesso');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $funcao = PessoaFuncaoMinisterial::findOrFail($id);
        return view('prebendas.editar_funcao_ministerial', ['funcao' => $funcao]);
    }


    public function update(Request $request, $id)
    {
        app(UpdateFuncaoMinisterialClerigosService::class)->execute($request, $id);
        return redirect()->route('clerigos.prebendas.index')->with('success', 'Valor da prebenda alterado com sucesso')->withInput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function createPrebenda()
    {
        $prebendas = Prebenda::all();
        return view('prebendas.nova_prebenda', ['prebendas' => $prebendas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePrebenda(Request $request)
    {
        app(StorePrebendasClerigosService::class)->execute($request);
        return redirect()->route('clerigos.prebendas.index')->with('success', 'Prebenda criada com sucesso');
    }

    public function updatePrebenda(Request $request)
    {
        app(UpdatePrebendaClerigosService::class)->execute($request);
        return redirect()->route('clerigos.prebendas.index')->with('success', 'Valor da prebenda alterado com sucesso')->withInput();
    }
}
