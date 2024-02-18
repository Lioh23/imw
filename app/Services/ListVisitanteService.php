<?php

namespace App\Services;

use App\Models\MembresiaContato;
use App\Models\MembresiaMembro;
use Illuminate\Support\Facades\Auth;

class ListVisitanteService
{
    public function execute()
    {
        $visitantes = MembresiaMembro::where('vinculo', MembresiaMembro::VINCULO_VISITANTE)
            ->join('membresia_contatos', 'membresia_membros.id', '=', 'membresia_contatos.membro_id')
            ->paginate(100, [
                'membresia_membros.id',
                'membresia_membros.nome',
                'membresia_contatos.telefone_preferencial',
                'membresia_contatos.email_preferencial',
                'membresia_membros.updated_at'
            ]);
    
        return $visitantes;
    }
}


