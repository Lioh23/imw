<?php

namespace App\Services;

use App\Models\MembresiaContato;
use App\Models\MembresiaMembro;

class TornarCongregadoService
{

    public function execute($id): void
    {

    }

    public function findOne($id): ?MembresiaMembro
    {
        $visitante = MembresiaMembro::select(
            'membresia_membros.*',
            'membresia_contatos.*'
        )
        ->join('membresia_contatos', 'membresia_membros.id', '=', 'membresia_contatos.membro_id')
        ->where('membresia_membros.id', $id)
        ->where('membresia_membros.vinculo', MembresiaMembro::VINCULO_VISITANTE)
        ->first();

        return $visitante;
    }
}