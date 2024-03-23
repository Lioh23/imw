<?php

namespace App\Services\ServiceVisitantes;

use App\Models\MembresiaMembro;
use App\Traits\MemberCountable;

class ListVisitanteService
{
    use MemberCountable;

    public function execute($parameters = null)
    {
        return [
            'visitantes'     => $this->handleListaVisitantes($parameters),
            'countAtivos'    => MemberCountable::countRolAtual(MembresiaMembro::VINCULO_VISITANTE),
            'countExcluidos' => MemberCountable::countRolPermanente(MembresiaMembro::VINCULO_VISITANTE),
            'countHasErrors' => MemberCountable::countHasErrors(MembresiaMembro::VINCULO_VISITANTE)
        ];
    }

    private function handleListaVisitantes($parameters)
    {
        return MembresiaMembro::with('contato')
            ->where('vinculo', MembresiaMembro::VINCULO_VISITANTE)
            ->when(isset($parameters['search']), function ($query) use ($parameters) {
                $searchTerm = $parameters['search'];
                $query->where('nome', 'like', "%$searchTerm%")
                    ->orWhereHas('contato', function ($subQuery) use ($searchTerm) { $subQuery->where('email_preferencial', 'like', "%$searchTerm%"); })
                    ->orWhereHas('contato', function ($subQuery) use ($searchTerm) { $subQuery->where('telefone_preferencial', 'like', "%$searchTerm%"); });
            })
            ->when(isset($parameters['excluido']), function ($query) {
                $query->onlyTrashed();
            })
            ->when(isset($parameters['has_errors']), function ($query) {
                $query->where('has_errors', 1);
            })
            ->paginate(100);

    } 
}


