<?php

namespace App\Services;

use App\Models\MembresiaContato;
use App\Models\MembresiaMembro;
use Illuminate\Support\Facades\Auth;

class PesquisarVisitanteService
{
    public function execute($searchTerm = null)
    {
        $query = MembresiaMembro::where('vinculo', MembresiaMembro::VINCULO_VISITANTE)
            ->join('membresia_contatos', 'membresia_membros.id', '=', 'membresia_contatos.membro_id');

            if (!is_null($searchTerm)) {
                $query = $query->where(function($query) use ($searchTerm) {
                    $query->where('membresia_membros.nome', 'like', '%' . $searchTerm . '%')
                        ->orWhere('membresia_contatos.email_preferencial', 'like', '%' . $searchTerm . '%')
                        ->orWhere('membresia_contatos.telefone_preferencial', 'like', '%' . $searchTerm . '%');
                });
            }

            $visitantes = $query->paginate(100, [
                'membresia_membros.id',
                'membresia_membros.nome',
                'membresia_contatos.telefone_preferencial',
                'membresia_contatos.email_preferencial',
                'membresia_membros.updated_at'
            ]);

            return $visitantes;
        }
}


