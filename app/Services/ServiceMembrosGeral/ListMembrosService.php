<?php 

namespace App\Services\ServiceMembrosGeral;

use App\Models\MembresiaMembro;
use App\Traits\Identifiable;
use App\Traits\MemberCountable;

class ListMembrosService
{
    use MemberCountable, Identifiable;

    public function execute($parameters = [])
    {
        return [
            'membros'         => $this->handleListaMembros($parameters),
            'countAtual'      => MemberCountable::countRolAtual(MembresiaMembro::VINCULO_MEMBRO),
            'countPermanente' => MemberCountable::countRolPermanente(MembresiaMembro::VINCULO_MEMBRO),
            'countHasErrors'  => MemberCountable::countHasErrors(MembresiaMembro::VINCULO_MEMBRO)
        ];
    }

    private function handleListaMembros($parameters = [])
    {
        return MembresiaMembro::with('congregacao', 'rolAtual')
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->where('vinculo', MembresiaMembro::VINCULO_MEMBRO)
            ->when(isset($parameters['search']), function ($query) use ($parameters) {
                $searchTerm = $parameters['search'];
                $query->where('nome', 'like', "%$searchTerm%")
                    ->orWhereHas('congregacao', function ($subQuery) use ($searchTerm) { $subQuery->where('nome', 'like', "%$searchTerm%"); });
            })
            ->when((isset($parameters['status']) && $parameters['status'] == 'rol_atual' || !isset($parameters['status'])), function ($query) {
                $query->whereHas('rolAtual', function ($sub) {
                    $sub->withoutGlobalScopes()->where('status', 'A');
                });
            })
            ->when(isset($parameters['status']) && $parameters['status'] == 'inativo', function ($query) {
                $query->whereHas('rolAtual', function ($sub) {
                    $sub->withoutGlobalScopes()->where('status', 'I');
                });
            })
            ->when(isset($parameters['status']) && $parameters['status'] == 'rol_permanente', function ($query) {
                $query->whereHas('rolAtual', function ($sub) {
                    $sub->withoutGlobalScopes()->whereIn('status', ['A', 'I']);
                });
            })
            ->when(isset($parameters['status']) && $parameters['status'] == 'has_errors', function ($query) {
                $query->withoutGlobalScopes()->where('has_errors', 1);
            })
            ->withTrashed()
            ->orderBy('nome')
            ->paginate(50);
    }
}