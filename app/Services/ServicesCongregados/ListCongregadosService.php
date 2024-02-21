<?php 

namespace App\Services\ServicesCongregados;

use App\Models\MembresiaMembro;

class ListCongregadosService
{
    public function execute($searchTerm = null)
    {
        $congregados = MembresiaMembro::with('congregacao')
            ->where('vinculo', MembresiaMembro::VINCULO_CONGREGADO)
            ->when((bool) $searchTerm, function ($query) use ($searchTerm) {
                $query->where('nome', 'like', "%$searchTerm%")
                    ->orWhereHas('congregacao', function ($subQuery) use ($searchTerm) { $subQuery->where('nome', 'like', "%$searchTerm%"); });
            })
            ->paginate(100);

        return $congregados;
    }
}