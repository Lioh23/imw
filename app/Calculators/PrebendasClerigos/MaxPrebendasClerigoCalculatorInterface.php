<?php

namespace App\Calculators\PrebendasClerigos;

use App\Models\PessoasPessoa;
use App\Models\Prebenda;

interface MaxPrebendasClerigoCalculatorInterface
{
    public function calculate(PessoasPessoa $pessoa, Prebenda $prebenda): float;
}
