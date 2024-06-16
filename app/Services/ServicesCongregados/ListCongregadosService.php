<?php 

namespace App\Services\ServicesCongregados;

use App\Models\MembresiaMembro;
use App\Traits\Identifiable;
use App\Traits\MemberCountable;

class ListCongregadosService
{
    use MemberCountable, Identifiable;

    public function execute()
    {
        return [
            'countHasErrors' => MemberCountable::countHasErrors(MembresiaMembro::VINCULO_CONGREGADO),
            'countAtivos'    => MemberCountable::countRolAtual(MembresiaMembro::VINCULO_CONGREGADO),
            'countExcluidos' => MemberCountable::countExcluidos(MembresiaMembro::VINCULO_CONGREGADO)
        ];
    }
}