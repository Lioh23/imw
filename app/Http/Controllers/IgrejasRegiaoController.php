<?php

namespace App\Http\Controllers;

use App\Models\InstituicoesInstituicao;
use App\Services\ServiceDatatable\IgrejasRegiaoDataTable;
use App\Services\ServiceIgrejas\BalanceteService;
use App\Services\ServiceIgrejas\GetEstatisticaAnoEclesiasticoService;
use App\Services\ServiceIgrejas\LivroRazaoService;
use App\Services\ServiceIgrejas\MovimentoDiarioService;
use App\Traits\LocationUtils;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;

class IgrejasRegiaoController extends Controller
{
    use LocationUtils;

    public function index()
    {
        return view('igrejas-regiao.index');
    }

    public function list(Request $request)
    {
        try {
            return app(IgrejasRegiaoDataTable::class)->execute($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Não foi possível listar as igrejas'], 500);
        }
    }

}