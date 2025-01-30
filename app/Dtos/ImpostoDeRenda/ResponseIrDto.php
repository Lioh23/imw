<?php

namespace App\Dtos\ImpostoDeRenda;

use Illuminate\Support\Collection;

class ResponseIrDto
{
    public function __construct(
        public ?int $ano = null,
        public ?float $rendimentosTributaveis = null,
        public ?int $qtdeDependentes = null,
        public ?int $valorDedutivel = null,
        public ?int $valorBase = null,
        public ?float $impostoSemDeducao = null,
        public ?float $valorImposto = null,
        public ?Collection $progressao = null,
    ) {
        $this->progressao = $progressao ?? collect();
    }
}
