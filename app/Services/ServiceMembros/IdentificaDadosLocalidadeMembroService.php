<?php 

namespace App\Services\ServiceMembros;

use App\Models\MembresiaMembro;

class IdentificaDadosLocalidadeMembroService
{
    public function execute ($id)
    {
        return [
            'distrito_id' => $this->fetchDistrito($id),
            'igreja_id' => $this->fetchIgreja($id),
            'regiao_id' => $this->fetchRegiao($id),
            'congregacao_id' => $this->fetchCongregacao($id),
        ];
    }

    private function fetchDistrito ($id) {
        return MembresiaMembro::where('id', $id)->first()->distrito_id;
    }

    private function fetchIgreja ($id) {
        return MembresiaMembro::where('id', $id)->first()->igreja_id;
    }
    private function fetchRegiao ($id) {
        return MembresiaMembro::where('id', $id)->first()->regiao_id;
    }
    private function fetchCongregacao ($id) {
        return MembresiaMembro::where('id', $id)->first()->congregacao_id;
    }
}