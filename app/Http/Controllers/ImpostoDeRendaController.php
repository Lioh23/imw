<?php

namespace App\Http\Controllers;

use App\Calculators\ImpostoDeRenda\ImpostoDeRendaSimplificadoCalculator;
use App\Models\PessoasPrebenda;
use App\Services\ServiceClerigosImpostoDeRenda\CalculaImpostoDeRendaService;
use Illuminate\Http\Request;

class ImpostoDeRendaController extends Controller
{
    public function index()
    {
        

        return view('perfil.clerigos.imposto-de-renda.index', $data);
        
    }

    public function loadHTML(PessoasPrebenda $prebenda)
    {
        try {
            $irCalculator = new ImpostoDeRendaSimplificadoCalculator();
            $data = (new CalculaImpostoDeRendaService($irCalculator))->execute($prebenda );
    
            # TODO (RETORNAR A O HTML COM OS DADOS DO IMPOSTO DE RENDA)
        } catch (\Exception $e) {
            # TODO retorar alguma mensagem de erro, ou alguma view de erro
        }
    }
}
