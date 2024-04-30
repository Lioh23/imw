<?php

namespace App\Http\Controllers;

use App\Services\ServiceRelatorio\IdentificaDadosRelatorioAniversariantesService;
use App\Services\ServiceRelatorio\IdentificaDadosRelatorioHistoricoEclesiasticoService;
use App\Services\ServiceRelatorio\IdentificaDadosRelatorioMembresiaService;
use Illuminate\Http\Request;
use PDF;

class RelatorioController extends Controller
{
    public function membresia(Request $request)
    {
        try {
            $data = app(IdentificaDadosRelatorioMembresiaService::class)->execute($request->all());

            if($data['render'] == 'view') {
                return view('relatorios.membresia', $data);
            }

            $pdf = PDF::loadView('relatorios.pdf.membresia', $data);
            return $pdf->inline('RELATORIO_MEMBROS_' . date('YmdHis') . '.pdf');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível abrir a página de relatórios de membresia');
        }
    }

    public function aniversariantes(Request $request)
    {
        try {
            $data = app(IdentificaDadosRelatorioAniversariantesService::class)->execute($request->all());
            
            if($data['render'] == 'view') {
                return view('relatorios.aniversariantes', $data);
            }

            $pdf = PDF::loadView('relatorios.pdf.aniversariantes', $data);
            return $pdf->inline('RELATORIO_MEMBROS_' . date('YmdHis') . '.pdf');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível abrir a página de relatórios de aniversariantes');
        }
    }

    public function historicoEclesiastico(Request $request)
    {
        try {
            $data = app(IdentificaDadosRelatorioHistoricoEclesiasticoService::class)->execute($request->all());

            if($data['render'] == 'view') {
                return view('relatorios.historico-eclesiastico', $data);
            }

            $pdf = PDF::loadView('relatorios.pdf.historico-eclesiastico', $data);
            return $pdf->inline('RELATORIO_MEMBROS_' . date('YmdHis') . '.pdf');

        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Não foi possível abrir a página de relatórios de histórico eclesiástico');
        }
    }
}
