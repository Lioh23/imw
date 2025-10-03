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

//ano
function getYear($value, $format = 'Y')
{
    return Carbon\Carbon::parse($value)->format($format);
}

//ano
function getMonth($value, $format = 'm')
{
    return Carbon\Carbon::parse($value)->format($format);
}


function decimal($value){
    return number_format($value, 2, '.', '.');
}

function formatMesAnoDizimo($value){
    if($value){
        $dados = explode('/',$value);
        $mes = str_pad($dados[0],  2, "0", STR_PAD_LEFT);
        $ano = $dados[1];
        $dia = '01';
        if($mes == 13){
            // $mes = '01';
            // $anoAlterado = $ano+1;
            $mes = '12';
            $anoAlterado = $ano;
            $data =  $anoAlterado.'-'.$mes.'-'.$dia;
        }else{
            $data =  $ano.'-'.$mes.'-'.$dia;
        }
    }else{
        $data = null;
    }
    
    return $data;
}

function zeroEsqueda($value){
    return  str_pad($value,  2, "0", STR_PAD_LEFT);
}

function generateGUID()
{
    mt_srand((float)microtime() * 10000);
    $charid = strtoupper(md5(uniqid(rand(), true)));
    $hyphen = chr(45); // "-"
    $uuid = substr(date('YmdHis'), 0, 14) . $hyphen
    . substr($charid, 0, 8) . $hyphen
    . substr($charid, 8, 4) . $hyphen
    . substr($charid, 12, 4) . $hyphen
    . substr($charid, 16, 4) . $hyphen
    . substr($charid, 20, 12);
    return $uuid;
}

function calculoPorcentagem($valorTotal, $percentual){
    return ($valorTotal / 100) * $percentual;
}