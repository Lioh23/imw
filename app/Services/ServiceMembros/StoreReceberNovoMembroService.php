<?php 

namespace App\Services\ServiceMembros;

use App\Exceptions\StoreRolPermanenteException;
use App\Models\MembresiaMembro;
use App\Models\MembresiaRolPermanente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreReceberNovoMembroService
{
    public function execute(array $params, $id)
    {
        try {
            $params = $this->fetchCreateParams($params);

            DB::beginTransaction();
            $pessoa = MembresiaMembro::find($id);
            $pessoa->update(['vinculo' => MembresiaMembro::VINCULO_MEMBRO]);
            $pessoa->rolPermanente()->create($params);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new StoreRolPermanenteException('Erro ao criar dados na tabela de Rol Permanente');
        }
    }

    private function fetchCreateParams($params)
    {
        $params['status']      = MembresiaRolPermanente::STATUS_ADESAO;
        $params['regiao_id']   = Auth::user()->regioes->first()->id;
        $params['distrito_id'] = Auth::user()->distritos->first()->id;
        $params['igreja_id']   = Auth::user()->igrejasLocais->first()->id;

        return $params;
    }
}