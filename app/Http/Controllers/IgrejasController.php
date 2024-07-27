<?php

namespace App\Http\Controllers;

use App\Services\ServiceDatatable\IgrejasDataTable;
use Illuminate\Http\Request;

class IgrejasController extends Controller
{
    public function index()
    {
        return view('igrejas.index');
    }

    public function list(Request $request)
    {
        try {
            return app(IgrejasDataTable::class)->execute();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Não foi possível listar as igrejas'], 500);
        }
    }

    public function novo()
    {

    }

    public function store()
    {

    }

    public function editar()
    {

    }

    public function update()
    {

    }

    public function desativar()
    {

    }

    public function restaurar()
    {

    }
}
