<?php

namespace App\Http\Controllers;

use App\Services\ServiceRelatorio\IdentificaDadosRelatorioService;
use Illuminate\Http\Request;
use PDF;

class RelatorioController extends Controller
{
    public function membresia(Request $request)
    {
        try {
            $data = app(IdentificaDadosRelatorioService::class)->execute($request->all());

            if($data['render'] == 'view') {
                return view('relatorios.membresia', $data);
            }

            $pdf = PDF::loadView('relatorios.pdf.membresia', $data);
            return $pdf->inline('RELATORIO_MEMBROS_' . date('YmdHis') . '.pdf');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível abrir a página de nova movimentação de transferência');
        }
    }
}
