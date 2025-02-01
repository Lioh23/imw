<?php

namespace Database\Seeders;

use App\Models\DeducaoIr;
use App\Models\TabelaIr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaseIrpf2024Seeder extends Seeder
{
    public function run()
    {
        DB::beginTransaction();

        // faixas
        $faixas = [
            [ 'ano' => 2024, 'faixa' => 1, 'deducao_faixa' => 2122.00, 'valor_min' => 0,       'valor_max' => 2259.2,  'aliquota' => 0,    'deducao' => 0      ],
            [ 'ano' => 2024, 'faixa' => 2, 'deducao_faixa' => 714.65,  'valor_min' => 2259.21, 'valor_max' => 2828.65, 'aliquota' => 7.5,  'deducao' => 169.44 ],
            [ 'ano' => 2024, 'faixa' => 3, 'deducao_faixa' => 924.40,  'valor_min' => 2828.66, 'valor_max' => 3751.05, 'aliquota' => 15,   'deducao' => 381.44 ],
            [ 'ano' => 2024, 'faixa' => 4, 'deducao_faixa' => 913.63,  'valor_min' => 3751.06, 'valor_max' => 4664.08, 'aliquota' => 22.5, 'deducao' => 662.77 ],
            [ 'ano' => 2024, 'faixa' => 5, 'deducao_faixa' => 807.32,  'valor_min' => 4664.09, 'valor_max' => null,    'aliquota' => 27.5, 'deducao' => 896    ],
        ];

        foreach ($faixas as $faixa) {
            TabelaIr::create($faixa);
        }

        // deduções
        $deducoes = [
            [  'ano' => 2024, 'tipo' => 'dependente',            'valor' => 189.59, 'simplificado' => false ],
            [  'ano' => 2024, 'tipo' => 'desconto_simplificado', 'valor' => 528.80, 'simplificado' => true ]
        ];

        foreach ($deducoes as $deducao) {
            DeducaoIr::create($deducao);
        }

        DB::commit();
    }
}
