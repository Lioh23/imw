<?php

namespace App\Calculators\ImpostoDeRenda;

use App\Dtos\ImpostoDeRenda\ResponseIrDto;

interface ImpostoDeRendaCalculatorInterface
{
  public function calculate(int $ano, float $rendimentosTributaveis, int $qtdeDependentes): ResponseIrDto;
}
