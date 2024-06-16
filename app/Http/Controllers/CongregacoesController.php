<?php

namespace App\Http\Controllers;

use App\Services\ServiceDatatable\CongregacoesDatatable;
use Illuminate\Http\Request;

class CongregacoesController extends Controller
{
    public function index()
    {
        return view('congregacoes.index');
    }

    public function list(Request $request)
    {
        try {
            return app(CongregacoesDatatable::class)->execute($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Não foi possível listar as congregações'], 500);
        }
    }

    public function novo()
    {

    }

    public function update()
    {

    }

    public function store()
    {

    }

    public function desativar()
    {

    }

    public function editar()
    {

    }

    public function restaurar()
    {

    }
}
