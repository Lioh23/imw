<?php 

namespace App\Services\ServiceMembros;

use App\Exceptions\StoreRolPermanenteException;
use App\Models\MembresiaMembro;
use App\Models\MembresiaRolPermanente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreReintegracaoService
{
    public function execute(array $params, $id)
    {
        try {
            $params = $this->fetchParams($params);

            DB::beginTransaction();
            $pessoa = MembresiaMembro::onlyTrashed()->find($id);
            $pessoa->restore();
            $pessoa->update([
                'vinculo'         => MembresiaMembro::VINCULO_MEMBRO, 
                'rol_atual'      => $params['numero_rol'], 
                'congregacao_id' => $params['congregacao_id'],
            ]);
            $pessoa->rolPermanente()->create($params);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new StoreRolPermanenteException('Erro ao criar dados na tabela de Rol Permanente');
        }
    }

    private function fetchParams($params)
    {
        $params['status']      = MembresiaRolPermanente::STATUS_ADESAO;
        $params['regiao_id']   = Auth::user()->regioes->first()->id;
        $params['distrito_id'] = Auth::user()->distritos->first()->id;
        $params['igreja_id']   = Auth::user()->igrejasLocais->first()->id;

        return $params;
    }
}