<?php 

namespace App\Services\ServiceMembros;

use App\Models\MembresiaMembro;
use App\Models\MembresiaSituacao;
use App\Traits\Identifiable;

class IdentificaDadosDisciplinaService
{
    use Identifiable;

    public function execute($id)
    {
        return [
            'pessoa'   => Identifiable::fetchPessoa($id, MembresiaMembro::VINCULO_MEMBRO),
            'pastores' => Identifiable::fetchPastores(),
            'modos'    => Identifiable::fetchModos(MembresiaSituacao::TIPO_DISCIPLINA),
        ];
    }
}