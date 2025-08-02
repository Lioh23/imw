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

if (!function_exists('formatarTelefone')) {
    function formatarTelefone($telefone)
    {
        if (empty($telefone)) {
            return '';
        }

        // Verificar se o número inclui o DDI (assumimos que o DDI tem 2 caracteres)
        if (strlen($telefone) >= 12) {
            $ddi = substr($telefone, 0, 2);  // Código do país
            $ddd = substr($telefone, 2, 2);  // Código de área (DDD)
            $numero = substr($telefone, 4);  // Número do telefone
        } else {
            $ddi = '';  // Sem código do país
            $ddd = substr($telefone, 0, 2);  // Código de área (DDD)
            $numero = substr($telefone, 2);  // Número do telefone
        }

        // Formatar número dependendo do seu comprimento
        if (strlen($numero) == 9) {
            // Número de celular
            $numero_formatado = substr($numero, 0, 5) . '-' . substr($numero, 5);
        } elseif (strlen($numero) == 8) {
            // Número de telefone fixo
            $numero_formatado = substr($numero, 0, 4) . '-' . substr($numero, 4);
        } else {
            // Formato desconhecido, exibir como está
            $numero_formatado = $numero;
        }

        if ($ddi) {
            return '+'.$ddi.' ('.$ddd.') '.$numero_formatado;
        } else {
            return '('.$ddd.') '.$numero_formatado;
        }
    }
}

if (!function_exists('clearFormatNumber')) {
    function clearFormatNumber($number)
    {
        $number = preg_replace('/[^0-9]/', '', $number);
        return $number;
    }
}

//Formata as datas d/m/Y H:i:s
function formatDateAndTime($value, $format = 'd/m/Y H:i:s')
{
    return Carbon\Carbon::parse($value)->format($format);
}

//Formata as datas d/m/Y
function formatDate($value, $format = 'd/m/Y')
{
    return Carbon\Carbon::parse($value)->format($format);
}

function decimal($value){
    return number_format($value, 2, '.', '.');
}