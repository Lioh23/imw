<?php

namespace App\Services\ServiceMembros;

use App\Exceptions\MembresiaRolPermanenteNotFoundException;
use App\Exceptions\UpdateNotificationException;
use App\Exceptions\UpdateRolReceberMembroExternoException;
use App\Models\MembresiaRolPermanente;
use App\Models\NotificacaoTransferencia;
use App\Traits\Identifiable;
use Illuminate\Support\Facades\Auth;

class StoreReceberMembroExternoService 
{
    use Identifiable;

    public function execute (array $params, NotificacaoTransferencia $notificacao) 
    {
        $this->handleUpdateNotificacao($params, $notificacao);

        if($params['action'] == 'accept')
            $this->handleUpdateRolMembro($params, $notificacao->membro);
    }

    private function handleUpdateNotificacao($params, $notificacao)
    {
        try {
            $updateParams = [];
            $updateParams['user_finalizacao'] = Auth::user()->id;
    
            if($params['action'] == 'accept')
                $updateParams['dt_aceite'] = $params['dt_resposta'];
            else
                $updateParams['dt_rejeicao'] = $params['dt_resposta'];
    
            $notificacao->update($updateParams);
        } catch (\Exception $e) {
            throw new UpdateNotificationException();
        }
    }

    private function handleUpdateRolMembro($params, $membro)
    {
        try {
            $this->handleRemoveRolAnterior($membro, $params['dt_resposta']);
            $this->handleCreateNewRol($membro, $params);

            $membro->update([
                ...Identifiable::fetchSessionInstituicoesStoreMembresia(),
                'congregacao_id' => $params['congregacao_id'],
            ]);

        } catch (\Exception $e) {
            throw new UpdateRolReceberMembroExternoException();
        }
    }

    private function handleRemoveRolAnterior($membro, $dtExclusao)
    {
        $updateParams = [
            'status'           => MembresiaRolPermanente::STATUS_EXCLUSAO,
            'modo_exclusao_id' => 10,  // transferencia para outra igreja Wesleyana
            'dt_exclusao'      => $dtExclusao
        ];

        $rolAtual = MembresiaRolPermanente::where('membro_id', $membro->id)
            ->where('numero_rol', $membro->rol_atual)
            ->where('igreja_id', $membro->igreja_id)
            ->orderByDesc('id')
            ->firstOr(fn () => throw new MembresiaRolPermanenteNotFoundException());
        
        $rolAtual->update($updateParams);
    }

    private function handleCreateNewRol($membro, $params)
    {
        MembresiaRolPermanente::create([
            'status'           => MembresiaRolPermanente::STATUS_TRANSFERENCIA,
            'numero_rol'       => $params['numero_rol'],
            'dt_recepcao'      => $params['dt_resposta'],
            'clerigo_id'       => $params['clerigo_id'],
            'membro_id'        => $membro->id,
            'modo_recepcao_id' => 4, // Membros vindos de outras Igrejas Wesleyana
            'congregacao_id'   => $params['congregacao_id'],
            ...Identifiable::fetchSessionInstituicoesStoreMembresia()
        ]);
    }
}
