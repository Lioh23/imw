<?php 

namespace App\Services\ServicesCongregados;

use App\Models\MembresiaMembro;
use App\Traits\Identifiable;
use App\Traits\MemberCountable;

class ListCongregadosService
{
    use MemberCountable, Identifiable;

    public function execute($parameters = [])
    {
        return [
            'congregados'    => $this->handleListaCongregados($parameters),
            'countHasErrors' => MemberCountable::countHasErrors(MembresiaMembro::VINCULO_CONGREGADO),
            'countAtivos'    => MemberCountable::countRolAtual(MembresiaMembro::VINCULO_CONGREGADO),
            'countExcluidos' => MemberCountable::countExcluidos(MembresiaMembro::VINCULO_CONGREGADO)
        ];
    }

    private function handleListaCongregados($parameters = [])
    {
        return MembresiaMembro::with('congregacao')
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->where('vinculo', MembresiaMembro::VINCULO_CONGREGADO)
            ->when(isset($parameters['search']), function ($query) use ($parameters) {
                $searchTerm = $parameters['search'];
                $query->where('nome', 'like', "%$searchTerm%")
                    ->orWhereHas('congregacao', function ($subQuery) use ($searchTerm) { $subQuery->where('nome', 'like', "%$searchTerm%"); });
            })
            ->when(isset($parameters['status']) && $parameters['status'] == 'has_errors', function ($query) {
                $query->where('has_errors', 1);
            })
            ->when(isset($parameters['status']) && $parameters['status'] == 'inativo', function ($query) {
                $query->onlyTrashed();
            })
            ->paginate(100);
    }
}