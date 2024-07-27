<?php

namespace App\Http\Controllers;

use App\Services\ServiceDistritoRelatorios\LancamentoIgrejasService;
use Illuminate\Http\Request;

class DistritoRelatorioController extends Controller
{
    public function  lancamentodasigrejas(Request $request)
    {
        $dt = $request->input('dtano');
        $igrejasID = $request->input('igreja_id');

        $data = app(LancamentoIgrejasService::class)->execute($dt, $igrejasID);
        return view('distrito.relatorios.lancamentodasigrejas', $data);
    }
}
