<?php 

namespace App\Traits;

trait LocationUtils
{
    public static function fetchUFs()
    {
        return [
            'AC' => 'Acre', 
            'AL' => 'Alagoas', 
            'AP' => 'Amapá', 
            'AM' => 'Amazonas',
            'BA' => 'Bahia', 
            'CE' => 'Ceará', 
            'DF' => 'Distrito Federal', 
            'ES' => 'Espírito Santo',
            'GO' => 'Goiás', 
            'MA' => 'Maranhão', 
            'MT' => 'Mato Grosso', 
            'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais', 
            'PA' => 'Pará', 
            'PB' => 'Paraíba', 
            'PR' => 'Paraná',
            'PE' => 'Pernambuco', 
            'PI' => 'Piauí', 
            'RJ' => 'Rio de Janeiro', 
            'RN' => 'Rio Grande do Norte',
            'RS' => 'Rio Grande do Sul', 
            'RO' => 'Rondônia', 
            'RR' => 'Roraima', 
            'SC' => 'Santa Catarina',
            'SP' => 'São Paulo', 
            'SE' => 'Sergipe', 
            'TO' => 'Tocantins'
        ];
    }

    public static function fetchPaises($uf)
    {
        return [
            'BR' => 'Brasil',
            'AF' => 'Afeganistão',
            'ZA' => 'África do Sul',
            'AL' => 'Albânia',
            'DE' => 'Alemanha',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antártida',
            'AG' => 'Antígua e Barbuda',
            'SA' => 'Arábia Saudita',
            'DZ' => 'Argélia',
            'AR' => 'Argentina',
            'AM' => 'Armênia',
            'AW' => 'Aruba',
            'AU' => 'Austrália',
            'AT' => 'Áustria',
            'AZ' => 'Azerbaijão',
            'BS' => 'Bahamas',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BH' => 'Bahrein',
            'BY' => 'Belarus',
            'BE' => 'Bélgica',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermudas',
            'BO' => 'Bolívia',
            'BA' => 'Bósnia e Herzegovina',
            'BW' => 'Botsuana',
            'BN' => 'Brunei',
            'BG' => 'Bulgária',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'BT' => 'Butão',
            'CV' => 'Cabo Verde',
            'KH' => 'Camboja',
            'CM' => 'Camarões',
            'CA' => 'Canadá',
            'KZ' => 'Cazaquistão',
            'EA' => 'Ceuta e Melilha',
            'TD' => 'Chade',
            'CL' => 'Chile',
            'CN' => 'China',
            'CY' => 'Chipre',
            'SG' => 'Cingapura',
            'CO' => 'Colômbia',
            'KM' => 'Comores',
            'CG' => 'Congo - Brazzaville',
            'CD' => 'Congo - Kinshasa',
            'KP' => 'Coreia do Norte',
            'KR' => 'Coreia do Sul',
            'CI' => 'Costa do Marfim',
            'CR' => 'Costa Rica',
            'HR' => 'Croácia',
            'CU' => 'Cuba',
            'CW' => 'Curaçao',
            'DG' => 'Diego Garcia',
            'DK' => 'Dinamarca',
            'DJ' => 'Djibuti',
            'DM' => 'Dominica',
            'EG' => 'Egito',
            'SV' => 'El Salvador',
            'AE' => 'Emirados Árabes Unidos',
            'EC' => 'Equador',
            'ER' => 'Eritreia',
            'SK' => 'Eslováquia',
            'SI' => 'Eslovênia',
            'ES' => 'Espanha',
            'US' => 'Estados Unidos',
            'EE' => 'Estônia',
            'ET' => 'Etiópia',
            'EU' => 'União Europeia',
            'FO' => 'Ilhas Faroe',
            'FJ' => 'Fiji',
            'PH' => 'Filipinas',
            'FI' => 'Finlândia',
            'FR' => 'França',
            'GA' => 'Gabão',
            'GM' => 'Gâmbia',
            'GH' => 'Gana',
            'GE' => 'Geórgia',
            'GS' => 'Geórgia do Sul e Ilhas Sandwich do Sul',
            'GI' => 'Gibraltar',
            'GD' => 'Granada',
            'GR' => 'Grécia',
            'GL' => 'Groênlandia',
            'GP' => 'Guadalupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GY' => 'Guiana',
            'GF' => 'Guiana Francesa',
            'GN' => 'Guiné',
            'GW' => 'Guiné Bissau',
            'GQ' => 'Guiné Equatorial',
            'HT' => 'Haiti',
            'NL' => 'Holanda',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong, RAE da China',
            'HU' => 'Hungria',
            'YE' => 'Iêmen',
            'IM' => 'Ilha de Man',
            'NF' => 'Ilha Norfolk',
            'AX' => 'Ilhas Åland',
            'KY' => 'Ilhas Cayman',
            'CC' => 'Ilhas Cocos (Keeling)',
            'CK' => 'Ilhas Cook',
            'FO' => 'Ilhas Faroe',
            'HM' => 'Ilhas Heard e McDonald',
            'FK' => 'Ilhas Malvinas',
            'MP' => 'Ilhas Marianas do Norte',
            'MH' => 'Ilhas Marshall',
            'UM' => 'Ilhas Menores Distantes dos EUA',
            'PN' => 'Ilhas Pitcairn',
            'SB' => 'Ilhas Salomão',
            'TC' => 'Ilhas Turks e Caicos',
            'VG' => 'Ilhas Virgens Britânicas',
            'VI' => 'Ilhas Virgens dos EUA',
            'IN' => 'Índia',
            'ID' => 'Indonésia',
            'IR' => 'Irã',
            'IQ' => 'Iraque',
            'IE' => 'Irlanda',
            'IS' => 'Islândia',
            'IL' => 'Israel',
            'IT' => 'Itália',
            'JM' => 'Jamaica',
            'JP' => 'Japão',
            'JE' => 'Jersey',
            'JO' => 'Jordânia',
            'XK' => 'Kosovo',
            'KW' => 'Kuwait',
            'LA' => 'Laos',
            'LS' => 'Lesoto',
            'LV' => 'Letônia',
            'LB' => 'Líbano',
            'LR' => 'Libéria',
            'LY' => 'Líbia',
            'LI' => 'Liechtenstein',
            'LT' => 'Lituânia',
            'LU' => 'Luxemburgo',
            'MO' => 'Macau, RAE da China',
            'MK' => 'Macedônia do Norte',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MV' => 'Maldivas',
            'MY' => 'Malásia',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MA' => 'Marrocos',
            'MQ' => 'Martinica',
            'MU' => 'Maurício',
            'MR' => 'Mauritânia',
            'YT' => 'Mayotte',
            'MX' => 'México',
            'MM' => 'Mianmar (Birmânia)',
            'FM' => 'Micronésia',
            'MZ' => 'Moçambique',
            'MD' => 'Moldávia',
            'MC' => 'Mônaco',
            'MN' => 'Mongólia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'NA' => 'Namíbia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'NI' => 'Nicarágua',
            'NE' => 'Níger',
            'NG' => 'Nigéria',
            'NU' => 'Niue',
            'NO' => 'Noruega',
            'NC' => 'Nova Caledônia',
            'NZ' => 'Nova Zelândia',
            'OM' => 'Omã',
            'PW' => 'Palau',
            'PA' => 'Panamá',
            'PG' => 'Papua-Nova Guiné',
            'PK' => 'Paquistão',
            'PY' => 'Paraguai',
            'PE' => 'Peru',
            'PF' => 'Polinésia Francesa',
            'PL' => 'Polônia',
            'PR' => 'Porto Rico',
            'PT' => 'Portugal',
            'KE' => 'Quênia',
            'KG' => 'Quirguistão',
            'KI' => 'Quiribati',
            'QO' => 'Oceania Remota',
            'GB' => 'Reino Unido',
            'CF' => 'República Centro-Africana',
            'CZ' => 'República Tcheca',
            'DO' => 'República Dominicana',
            'RE' => 'Reunião',
            'RO' => 'Romênia',
            'RW' => 'Ruanda',
            'RU' => 'Rússia',
            'EH' => 'Saara Ocidental',
            'KN' => 'Saint Kitts e Nevis',
            'SM' => 'San Marino',
            'PM' => 'Saint Pierre e Miquelon',
            'VC' => 'São Vicente e Granadinas',
            'SH' => 'Santa Helena',
            'LC' => 'Santa Lúcia',
            'ST' => 'São Tomé e Príncipe',
            'SN' => 'Senegal',
            'SL' => 'Serra Leoa',
            'RS' => 'Sérvia',
            'SC' => 'Seychelles',
            'SX' => 'Sint Maarten',
            'SY' => 'Síria',
            'SO' => 'Somália',
            'LK' => 'Sri Lanka',
            'SZ' => 'Suazilândia',
            'SD' => 'Sudão',
            'SS' => 'Sudão do Sul',
            'SE' => 'Suécia',
            'CH' => 'Suíça',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard e Jan Mayen',
            'TJ' => 'Tajiquistão',
            'TH' => 'Tailândia',
            'TW' => 'Taiwan',
            'TZ' => 'Tanzânia',
            'IO' => 'Território Britânico do Oceano Índico',
            'TF' => 'Territórios Franceses do Sul',
            'PS' => 'Territórios palestinos',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad e Tobago',
            'TN' => 'Tunísia',
            'TM' => 'Turcomenistão',
            'TC' => 'Turks e Caicos',
            'TV' => 'Tuvalu',
            'UA' => 'Ucrânia',
            'UG' => 'Uganda',
            'UY' => 'Uruguai',
            'UZ' => 'Uzbequistão',
            'VU' => 'Vanuatu',
            'VA' => 'Vaticano',
            'VE' => 'Venezuela',
            'VN' => 'Vietnã',
            'WF' => 'Wallis e Futuna',
            'ZM' => 'Zâmbia',
            'ZW' => 'Zimbábue',
        ];
    }
}