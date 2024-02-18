<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisitanteRequest;
use App\Services\StoreVisitanteService;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitantesController extends Controller
{

    public function index()
    {
        return view('visitantes.index');
    }

    public function novo()
    {
        return view('visitantes.create');
    }

    public function store(StoreVisitanteRequest $request)
    {
       try {
            DB::beginTransaction();
            app(StoreVisitanteService::class)->execute($request->all());
            DB::commit();
            
            Session::flash('success', 'Operação concluída com sucesso!');
            return redirect()->route('visitante.novo');
        } catch(\Exception $e) {
            DB::rollback();
            
            Session::flash('error', 'Operação concluída com sucesso!');
            return redirect()->route('visitante.novo');
       }
    }
}
