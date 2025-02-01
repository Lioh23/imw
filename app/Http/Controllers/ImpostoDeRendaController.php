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

    public function loadHTML(PessoasPrebenda $prebenda)
    {
        try {
            $irCalculator = new ImpostoDeRendaSimplificadoCalculator();
            $data = (new CalculaImpostoDeRendaService($irCalculator))->execute($prebenda);

            return view('perfil.clerigos.imposto-de-renda.vizualizar',  ['data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao visualizar dados desta prebenda. ' . $e->getMessage()], 500);
        }
    }
}
