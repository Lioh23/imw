<?php

namespace App\Calculators\PrebendasClerigos;

use App\Models\PessoaFuncaoministerial;
use App\Models\PessoasPessoa;
use App\Models\Prebenda;

class MaxPrebendasClerigoCalculator implements MaxPrebendasClerigoCalculatorInterface
{
    public function calculate(PessoasPessoa $pessoa, Prebenda $prebenda): float
    {
        $idsFuncoesMinisteriais = $pessoa->nomeacoesAtivas->pluck('funcao_ministerial_id');

		$maxQtdPrebendas = PessoaFuncaoministerial::whereIn('id', $idsFuncoesMinisteriais)
			->orderBy('qtd_prebendas', 'desc')
			->first()
			->qtd_prebendas;

        return $maxQtdPrebendas * $prebenda->valor;
    }
}
