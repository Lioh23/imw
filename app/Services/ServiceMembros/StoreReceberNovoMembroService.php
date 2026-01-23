<?php 

namespace App\Services\ServiceMembros;

use App\Exceptions\StoreRolPermanenteException;
use App\Models\MembresiaMembro;
use App\Models\MembresiaRolPermanente;
use App\Traits\Identifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreReceberNovoMembroService
{
    use Identifiable;

    public function execute(array $params, $id)
    {
        try {
            $params = $this->fetchCreateParams($params);
            DB::beginTransaction();
            $pessoa = MembresiaMembro::select('membresia_membros.*', DB::raw("TIMESTAMPDIFF(YEAR, data_nascimento, curdate()) idade"),)->find($id);
            if($pessoa->idade > 10){
                if(!$pessoa->data_batismo) {
                    return 'batismo';
                } else {
                    $pessoa->update([
                        'vinculo'        => MembresiaMembro::VINCULO_MEMBRO, 
                        'rol_atual'      => $params['numero_rol'], 
                        'congregacao_id' => $params['congregacao_id'],
                    ]);
                    $pessoa->rolPermanente()->create($params);
                    DB::commit();
                }                
            }else{
                return 'idade';
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new StoreRolPermanenteException('Erro ao criar dados na tabela de Rol Permanente');
        }
    }
    
    private function fetchCreateParams($params)
    {
        $params['status'] = MembresiaRolPermanente::STATUS_RECEBIMENTO;

        return [...$params, ...Identifiable::fetchSessionInstituicoesStoreMembresia()];
    }
}