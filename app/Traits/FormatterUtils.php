<?php

namespace App\Traits;

trait FormatterUtils
{
    public function formatCurrencyBRL(float $number, $symbol = false): string
    {
        $number = number_format($number,2,",",".");

        return $symbol ? "R$ $number" : $number;
    }
}
