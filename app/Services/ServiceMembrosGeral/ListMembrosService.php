<?php 

namespace App\Services\ServiceMembrosGeral;

use App\Models\MembresiaMembro;

class ListMembrosService
{
    public function execute($searchTerm = null)
    {
        $membros = MembresiaMembro::with('congregacao')
            ->where('vinculo', MembresiaMembro::VINCULO_MEMBRO)
            ->when((bool) $searchTerm, function ($query) use ($searchTerm) {
                $query->where('nome', 'like', "%$searchTerm%")
                    ->orWhereHas('congregacao', function ($subQuery) use ($searchTerm) { $subQuery->where('nome', 'like', "%$searchTerm%"); });
            })
            ->paginate(100);

        return $membros;
    }
}