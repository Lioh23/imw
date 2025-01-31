<?php

namespace App\Http\Controllers;

use App\Calculators\ImpostoDeRenda\ImpostoDeRendaSimplificadoCalculator;
use App\Models\DeducaoIr;
use App\Models\PessoasPrebenda;
use App\Models\TabelaIr;
use App\Services\ServiceClerigosImpostoDeRenda\CalculaImpostoDeRendaService;
use App\Traits\Identifiable;
use Illuminate\Http\Request;

class ImpostoDeRendaController extends Controller
{
    use Identifiable;
    public function index()
    {
        $prebendas = PessoasPrebenda::where('pessoa_id', Identifiable::fetchSessionPessoa()->id)->get();
        return view('perfil.clerigos.imposto-de-renda.index', ['prebendas' =>  $prebendas]);
    }

    public function loadHTML($prebendaId)
    {
        try {
            $irCalculator = new ImpostoDeRendaSimplificadoCalculator();
            $prebenda = PessoasPrebenda::where('id', $prebendaId)->first();
            if (!$prebenda) {
                throw new \Exception('Prebenda não encontrada.');
            }
            $TabelaIr = TabelaIr::where('ano', $prebenda->ano)->get();
            $DeducaoIr = DeducaoIr::where('ano', $prebenda->ano)->where('simplificado', true)->first();

            if ($TabelaIr->isEmpty() && !$DeducaoIr) {
                throw new \Exception('A prebenda de ' . $prebenda->ano . ' ainda nao esta parametrizado no sistema ');
            };
            $data = (new CalculaImpostoDeRendaService($irCalculator))->execute($prebenda);
            $dataArray = json_decode(json_encode($data), true);
            return response()->json(['html' => view('perfil.clerigos.imposto-de-renda.vizualizar',  ['dataArray' => $dataArray])->render()]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao visualizar dados desta prebenda. ' . $e->getMessage()], 500);
        }
    }
}
