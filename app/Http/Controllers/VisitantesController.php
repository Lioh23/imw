<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisitanteRequest;
use App\Services\StoreVisitanteService;
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
            
            return response()->json(['message' => 'Visitante salvo com sucesso!']);
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Ocorreu um erro ao salvar o visitante. tente novamente mais tarde!'], 500);
       }
    }
}
