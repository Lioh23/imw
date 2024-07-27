<?php

namespace App\Http\Controllers;

use App\Services\ServiceDistritoRelatorios\LancamentoIgrejasService;
use Illuminate\Http\Request;

class DistritoRelatorioController extends Controller
{
    public function  lancamentodasigrejas(Request $request)
    {
        $dt = $request->input('dtano');
        $distritoID = $request->input('distrito_id');

        $data = app(LancamentoIgrejasService::class)->execute($dt, $distritoID);
        return view('distrito.relatorios.lancamentodasigrejas', $data);
    }
}
