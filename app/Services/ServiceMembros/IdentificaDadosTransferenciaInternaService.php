<?php 

namespace App\Services\ServiceMembros;

use App\Models\MembresiaMembro;
use App\Models\MembresiaSituacao;
use App\Traits\Identifiable;
use Illuminate\Support\Facades\Auth;

class IdentificaDadosTransferenciaInternaService
{
    use Identifiable;

    public function execute($id)
    {
        $pessoa       = Identifiable::fetchPessoa($id, MembresiaMembro::VINCULO_MEMBRO);
        $congregacoes = Identifiable::fetchCongregacoes(Auth::user()->igrejasLocais->first()->id, $pessoa->congregacao_id);
        $pastores     = Identifiable::fetchPastores();

        return [
            'pessoa'       => $pessoa,
            'congregacoes' => $congregacoes,
            'pastores'     => $pastores,
        ];
    }
}