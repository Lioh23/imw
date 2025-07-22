<?php

namespace App\Http\Controllers;

use App\Services\ServiceContabilidade\CnpjIgreja;
use App\Services\ServiceContabilidade\IrrfServices;
use Illuminate\Http\Request;

class ContabilidadeController extends Controller
{
    public function irrf(Request $request)
    {
        $data = app(IrrfServices::class)->execute($request->all());
        return view('contabilidade.irrf.index', $data);
    }

    public function cnpjIgreja(Request $request)
    {
        $data = app(CnpjIgreja::class)->execute($request->all());
 
        return view('contabilidade.cnpj-igrejas', $data);
    }

}