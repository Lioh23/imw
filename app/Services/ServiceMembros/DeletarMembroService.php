<?php 

namespace App\Services\ServiceMembros;

use App\Exceptions\DeleteMembroException;
use App\Models\MembresiaMembro;
use App\Models\MembresiaRolPermanente;
use Illuminate\Support\Facades\DB;

class DeletarMembroService
{
    public function execute($data, $id): void
    {
        try {
            DB::beginTransaction();

            $membro   = $this->fetchMembro($id);
            $rolAtual = $this->fetchRolAtual($membro->id, $membro->rol_atual);

            $rolAtual->update(['modo_exclusao_id' => $data['modo_exclusao_id'], 'dt_exclusao' => $data['dt_exclusao']]);
            $membro->delete();
            
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            throw new DeleteMembroException();
        }
    }

    private function fetchMembro($id)
    {
        return MembresiaMembro::findOrFail($id);
    }

    private function fetchRolAtual($membroId, $numeroRol)
    {
        return MembresiaRolPermanente::where('membro_id', $membroId)
            ->where('numero_rol', $numeroRol)
            ->firstOr(fn() => throw new DeleteMembroException());
    }
}
