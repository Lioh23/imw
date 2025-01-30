<?php

namespace App\Dtos\ImpostoDeRenda;

class ProgressaoIrDto
{
    public function __construct(
        public ?int $faixa = null,
        public ?string $textBaseCalculo = null,
        public ?float $aliquota = null,
        public ?float $valorImposto = null,
    ) {}
}
