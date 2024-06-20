<?php 

namespace App\Services\ServiceMembros;

use App\Models\MembresiaMembro;
use App\Traits\Identifiable;
use App\Traits\MemberCountable;

class IdentificaDadosIndexService
{
    use MemberCountable, Identifiable;

    public function execute()
    {
        return [
            'countAtual'      => MemberCountable::countRolAtual(MembresiaMembro::VINCULO_MEMBRO),
            'countPermanente' => MemberCountable::countRolPermanente(MembresiaMembro::VINCULO_MEMBRO),
            'countHasErrors'  => MemberCountable::countHasErrors(MembresiaMembro::VINCULO_MEMBRO)
        ];
    }
}