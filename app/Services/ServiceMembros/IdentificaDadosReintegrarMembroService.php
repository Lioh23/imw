<?php 

namespace App\Services\ServiceMembros;

use App\Models\MembresiaMembro;
use App\Models\MembresiaSituacao;
use App\Traits\Identifiable;

class IdentificaDadosReintegrarMembroService
{ 
    use Identifiable;

    public function execute($id)
    {
        return [
            'pessoa'       => Identifiable::fetchPessoa($id, MembresiaMembro::VINCULO_MEMBRO, true),
            'sugestao_rol' => Identifiable::fetchSugestaoRol(),
            'pastores'     => Identifiable::fetchPastores(),
            'modos'        => Identifiable::fetchModos(MembresiaSituacao::TIPO_ADESAO),
            'congregacoes' => Identifiable::fetchCongregacoes()
        ];
    }
}
