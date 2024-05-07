<?php

if (!function_exists('formatStr')) {
    function formatStr($string, $formato) {
        $formattedString = '';
        $posicaoString = 0;
    
        // Percorre cada caractere do formato
        for ($i = 0; $i < strlen($formato); $i++) {
            // Se o caractere do formato for '#', substitui pelo próximo caractere da string
            if ($formato[$i] === '#') {
                // Verifica se ainda há caracteres na string
                if ($posicaoString < strlen($string)) {
                    $formattedString .= $string[$posicaoString];
                    $posicaoString++;
                }
            } else {
                $formattedString .= $formato[$i];
            }
        }
    
        return $formattedString;
    }
}