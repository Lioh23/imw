<?php 


namespace App\Services\ServiceVisitantes;

use App\Exceptions\DeleteMembroException;
use App\Models\MembresiaMembro;
use Illuminate\Support\Facades\DB;

class DeletarVisitanteService
{
    public function execute($membroId): void
    {
        try {
            DB::beginTransaction();
            $membro = MembresiaMembro::findOrFail($membroId);
            $membro->update(['status' => MembresiaMembro::STATUS_INATIVO]);
            $membro->delete(); 
            DB::commit();
        } catch(\Exception $e) {
            throw new DeleteMembroException();
        }
    }
}
