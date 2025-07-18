<?php

namespace App\Http\Controllers;

use App\Calculators\ImpostoDeRenda\ImpostoDeRendaSimplificadoCalculator;
use App\Models\DeducaoIr;
use App\Models\PessoasPrebenda;
use App\Models\TabelaIr;
use App\Services\ServiceClerigosImpostoDeRenda\CalculaImpostoDeRendaService;
use App\Traits\Identifiable;
use Illuminate\Http\Request;

class ContabilidadeController extends Controller
{
    use Identifiable;
    public function irrf(Request $request)
    {
        $prebendas = PessoasPrebenda::where('pessoa_id', Identifiable::fetchSessionPessoa()->id)->orderBy('ano', 'desc')->get();
        $data['prebendas'] =  $prebendas;
        $ano = $request->input('ano');
        if(isset($ano)) {
            $prebendaId = $request->input('ano');
            try {

                $prebenda = PessoasPrebenda::where('id', $prebendaId)->first();

                $irCalculator = new ImpostoDeRendaSimplificadoCalculator();

                $data['data'] = (new CalculaImpostoDeRendaService($irCalculator))->execute($prebenda);
 
            } catch (\Exception $e) {
                return response()->json(['message' => 'Erro ao visualizar dados desta prebenda. ' . $e->getMessage()], 500);
            }
        }

        return view('contabilidade.irrf.index', $data);
    }

}