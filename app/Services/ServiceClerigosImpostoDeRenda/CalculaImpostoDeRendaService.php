<?php

namespace App\Services\ServiceClerigosImpostoDeRenda;

use App\Calculators\ImpostoDeRenda\ImpostoDeRendaCalculatorInterface;
use App\Dtos\ImpostoDeRenda\ResponseIrDto;
use App\Models\DeducaoIr;
use App\Models\PessoasDependente;
use App\Models\PessoasPrebenda;
use App\Models\Prebenda;
use App\Models\TabelaIr;
use Carbon\Carbon;

class CalculaImpostoDeRendaService
{
    public function __construct(private ImpostoDeRendaCalculatorInterface $irCalculator) {}

    public function execute($prebenda): ResponseIrDto
    {


        $qtdDependentes = PessoasDependente::where('pessoa_id', $prebenda->pessoa_id)
            ->where('declarar_epessoa_idm_irpf', 1)
            ->count();


        return $this->irCalculator->calculate($prebenda->ano, $prebenda->valor, $qtdDependentes);
    }
}
