<?php

namespace App\Http\Controllers;

use App\Models\PessoasPessoa;
use App\Services\ServiceClerigosRegiao\DetalhesRegiaoClerigosService;
use App\Services\ServiceClerigosRegiao\ListaClerigosService;
use Illuminate\Http\Request;

class ClerigosRegiaoController extends Controller
{
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
        return view('clerigos.novo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function detalhes($id)
    {
        $instituicao = app(DetalhesRegiaoClerigosService::class)->execute($id);
        return response()->json($instituicao);
    }
}
