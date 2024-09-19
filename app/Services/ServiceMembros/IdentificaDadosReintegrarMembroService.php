<?php 

namespace App\Services\ServiceMembros;

use App\Models\MembresiaMembro;
use App\Models\MembresiaSituacao;
use App\Traits\Identifiable;

class IdentificaDadosReintegrarMembroService
{ 
    use Identifiable;

    public function execute($membroId)
    {
        return [
            'pessoa'       => Identifiable::fetchPessoa($membroId, MembresiaMembro::VINCULO_MEMBRO, true),
            'sugestao_rol' => Identifiable::fetchSugestaoRol($membroId),
            'pastores'     => Identifiable::fetchPastores(),
            'modos'        => Identifiable::fetchModos(MembresiaSituacao::TIPO_ADESAO),
            'congregacoes' => Identifiable::fetchCongregacoes()
        ];
    }
}
