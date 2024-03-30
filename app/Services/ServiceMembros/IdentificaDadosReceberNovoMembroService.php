<?php 

namespace App\Services\ServiceMembros;

use App\Models\MembresiaMembro;
use App\Models\MembresiaRolPermanente;
use App\Models\MembresiaSituacao;
use App\Traits\Identifiable;

class IdentificaDadosReceberNovoMembroService
{
    use Identifiable;

    public function execute($id)
    {
        return [
            'pessoa'       => Identifiable::fetchPessoa($id, MembresiaMembro::VINCULO_CONGREGADO),
            'sugestao_rol' => $this->fetchSugestaoRol(),
            'pastores'     => Identifiable::fetchPastores(),
            'modos'        => Identifiable::fetchModos(MembresiaSituacao::TIPO_ADESAO),
            'congregacoes' => Identifiable::fetchCongregacoes()
        ];
    }

    private function fetchSugestaoRol()
    {
        return MembresiaRolPermanente::selectRaw('IFNULL(MAX(numero_rol), 0) + 1 sugestao_rol')
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->first()->sugestao_rol;
    }
}