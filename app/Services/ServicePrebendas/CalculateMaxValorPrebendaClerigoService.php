<?php

namespace App\Services\ServicePrebendas;

use App\Calculators\PrebendasClerigos\MaxPrebendasClerigoCalculatorInterface;
use App\Models\Prebenda;
use App\Traits\Identifiable;

class CalculateMaxValorPrebendaClerigoService
{
	public function __construct(private MaxPrebendasClerigoCalculatorInterface $calculator) {}

	public function execute(int $ano): float
	{
		$pessoa   = Identifiable::fetchSessionPessoa();
		$prebenda = Prebenda::where('ano', $ano)->where('ativo', 1)->first();

        return $this->calculator->calculate($pessoa, $prebenda);
	}
}
