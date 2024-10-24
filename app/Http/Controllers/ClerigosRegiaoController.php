<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReceberNovoClerigoRequest;
use App\Models\Formacao;
use App\Models\PessoasPessoa;
use App\Services\ServiceClerigosRegiao\ListaClerigosService;
use App\Services\ServiceClerigosRegiao\StoreClerigosService;
use App\Services\ServiceClerigosRegiao\UpdateClerigosService;
use App\Traits\LocationUtils;
use Illuminate\Http\Request;

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
        return view('clerigos.novo', compact('ufs', 'formacoes'));
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        return view('clerigos.editar', compact('clerigo', 'ufs', 'formacoes'));
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
