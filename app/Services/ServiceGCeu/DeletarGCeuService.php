<?php 


namespace App\Services\ServiceGCeu;

use App\Exceptions\DeleteMembroException;
use App\Models\MembresiaMembro;
use Illuminate\Support\Facades\DB;

class DeletarGCeuService
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
