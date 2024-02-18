<?php

namespace App\Services;

use App\Models\MembresiaContato;
use App\Models\MembresiaMembro;
use Illuminate\Support\Facades\Auth;

class ListVisitanteService
{
    public function execute($searchTerm = null)
    {
        $visitantes = MembresiaMembro::with('contato')
            ->where('vinculo', MembresiaMembro::VINCULO_VISITANTE)
            ->when((bool) $searchTerm, function ($query) use ($searchTerm) {
                $query->where('nome', 'like', "%$searchTerm%")
                    ->orWhereHas('contato', function ($subQuery) use ($searchTerm) { $subQuery->where('email_preferencial', 'like', "%$searchTerm%"); })
                    ->orWhereHas('contato', function ($subQuery) use ($searchTerm) { $subQuery->where('telefone_preferencial', 'like', "%$searchTerm%"); });
            })
            ->paginate(100);
    
        return $visitantes;
    }
}


