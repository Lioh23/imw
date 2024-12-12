<?php

namespace App\Traits;

trait FakerUtils
{
    public static function generateRandomCpf(): string
    {
        // Gerar os 9 primeiros dígitos aleatórios
        $numeros = [];
        for ($i = 0; $i < 9; $i++) {
            $numeros[] = rand(0, 9);
        }

        // Cálculo do primeiro dígito verificador
        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += $numeros[$i] * (10 - $i);
        }
        $resto = $soma % 11;
        $primeiroDigito = $resto < 2 ? 0 : 11 - $resto;
        $numeros[] = $primeiroDigito;

        // Cálculo do segundo dígito verificador
        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += $numeros[$i] * (11 - $i);
        }
        $resto = $soma % 11;
        $segundoDigito = $resto < 2 ? 0 : 11 - $resto;
        $numeros[] = $segundoDigito;

        return implode('', $numeros);
    }
}
