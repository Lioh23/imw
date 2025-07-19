<?php

namespace App\Http\Controllers;

use App\Calculators\ImpostoDeRenda\ImpostoDeRendaSimplificadoCalculator;
use App\Models\DeducaoIr;
use App\Models\Mes;
use App\Models\PessoasPrebenda;
use App\Models\TabelaIr;
use App\Services\ServiceClerigosImpostoDeRenda\CalculaImpostoDeRendaService;
use App\Services\ServiceContabilidade\IrrfServices;
use App\Traits\Identifiable;
use Illuminate\Http\Request;

class ContabilidadeController extends Controller
{
    use Identifiable;
    public function irrf(Request $request)
    {
        $data = app(IrrfServices::class)->execute($request->all());
        
        return view('contabilidade.irrf.index', $data);
    }

}