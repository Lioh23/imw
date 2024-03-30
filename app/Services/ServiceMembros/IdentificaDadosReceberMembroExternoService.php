<?php 

namespace App\Services\ServiceMembros;

use App\Models\MembresiaMembro;
use App\Traits\Identifiable;

class IdentificaDadosReceberMembroExternoService
{
    use Identifiable;

    public function execute($id)
    {
        return [
            'pessoa'       => Identifiable::fetchPessoa($id, MembresiaMembro::VINCULO_MEMBRO),
            'pastores'     => Identifiable::fetchPastores(),
            'congregacoes' => Identifiable::fetchCongregacoes()
        ];
    }
}