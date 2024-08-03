<?php

namespace App\Http\Controllers;

use App\Models\InstituicoesInstituicao;
use App\Services\ServiceDatatable\IgrejasDataTable;
use App\Services\ServiceIgrejas\GetEstatisticaAnoEclesiasticoService;
use App\Traits\LocationUtils;
use Illuminate\Http\Request;

class IgrejasController extends Controller
{
    use LocationUtils;

    public function index()
    {
        return view('igrejas.index');
    }

    public function list(Request $request)
    {
        try {
            return app(IgrejasDataTable::class)->execute($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Não foi possível listar as igrejas'], 500);
        }
    }

    public function estatisticaAnoEclesiastico(Request $request, InstituicoesInstituicao $igreja)
    {
        try {
            $data = app(GetEstatisticaAnoEclesiasticoService::class)->execute($igreja, $request->input('ano'));
            return view('igrejas.estatistica-ano-eclesiastico', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Houve um erro ao tentar visualizar o relatório de histórico eclesiástico');
        }
    }
}
