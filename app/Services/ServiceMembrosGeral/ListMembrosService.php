<?php 

namespace App\Services\ServiceMembrosGeral;

use App\Models\MembresiaMembro;
use App\Traits\Identifiable;
use App\Traits\MemberCountable;

class ListMembrosService
{
    use MemberCountable, Identifiable;

    public function execute($parameters = null)
    {
        return [
            'membros'         => $this->handleListaMembros($parameters),
            'countAtual'      => MemberCountable::countRolAtual(MembresiaMembro::VINCULO_MEMBRO),
            'countPermanente' => MemberCountable::countRolPermanente(MembresiaMembro::VINCULO_MEMBRO),
            'countHasErrors'  => MemberCountable::countHasErrors(MembresiaMembro::VINCULO_MEMBRO)
        ];
    }

    private function handleListaMembros($parameters = null)
    {
        return MembresiaMembro::with('congregacao')
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->where('vinculo', MembresiaMembro::VINCULO_MEMBRO)
            ->when(isset($parameters['search']), function ($query) use ($parameters) {
                $searchTerm = $parameters['search'];
                $query->where('nome', 'like', "%$searchTerm%")
                    ->orWhereHas('congregacao', function ($subQuery) use ($searchTerm) { $subQuery->where('nome', 'like', "%$searchTerm%"); });
            })
            ->when(isset($parameters['rol_permanente']), function ($query) {
                $query->onlyTrashed();
            })
            ->when(isset($parameters['has_errors']), function ($query) {
                $query->where('has_errors', 1);
            })
            ->paginate(100);
    }
}