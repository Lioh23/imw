<?php

namespace App\Services\ServiceVisitantes;

use App\Models\MembresiaMembro;
use App\Traits\Identifiable;
use App\Traits\MemberCountable;

class IdentificaDadosIndexService
{
    use MemberCountable, Identifiable;

    public function execute()
    {
        return [
            'countAtivos'    => MemberCountable::countRolAtual(MembresiaMembro::VINCULO_VISITANTE),
            'countExcluidos' => MemberCountable::countExcluidos(MembresiaMembro::VINCULO_VISITANTE),
            'countHasErrors' => MemberCountable::countHasErrors(MembresiaMembro::VINCULO_VISITANTE)
        ];
    }
}
