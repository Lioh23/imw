<?php

namespace App\Services\ServicesCongregados;

use App\Models\MembresiaContato;
use App\Models\MembresiaFuncaoeclesiastica;
use App\Models\MembresiaMembro;
use App\Models\MembresiaSetor;

class TornarCongregadoService
{

    public function execute($id): void
    {
    }

    public function findOne($id)
    {
        //With trazer relacionamentos definidos do model MembresiaMembro de forma prévia
        $pessoa = MembresiaMembro::with(['contato', 'funcoesMinisteriais', 'familiar'])
            ->where('id', $id)
            ->whereIn('vinculo', [MembresiaMembro::VINCULO_VISITANTE, MembresiaMembro::VINCLULO_CONGREGADO])
            ->first();

        //Somente buscar informações do campo select
        $setores = MembresiaSetor::orderBy('descricao', 'asc')->get();
        $funcoes = MembresiaFuncaoeclesiastica::orderBy('descricao', 'asc')->get();

        return [
            'pessoa' => $pessoa,
            'setores' => $setores,
            'funcoes' => $funcoes
        ];
    }
}
