<?php 

namespace App\Services\ServiceMembros;

use App\Models\MembresiaMembro;
use App\Models\NotificacaoTransferencia;
use App\Traits\Identifiable;

class IdentificaDadosReceberMembroExternoService
{
    use Identifiable;

    public function execute(NotificacaoTransferencia $notificacao)
    {
        return [
            'pessoa'       => Identifiable::fetchPessoa($notificacao->membro_id, MembresiaMembro::VINCULO_MEMBRO),
            'pastores'     => Identifiable::fetchPastores(),
            'congregacoes' => Identifiable::fetchCongregacoes(),
            'sugestaoRol'  => Identifiable::fetchSugestaoRol(),
            'notificacao'  => $notificacao
        ];
    }
}