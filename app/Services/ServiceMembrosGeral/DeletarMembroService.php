<?php 

namespace App\Services\ServiceMembrosGeral;

use App\Exceptions\DeleteMembroException;
use App\Models\MembresiaMembro;
use Illuminate\Support\Facades\DB;

class DeletarMembroService
{
    public function execute($membroId): void
    {
        try {
            DB::beginTransaction();
            $membro = MembresiaMembro::findOrFail($membroId);
            $membro->delete();          
            DB::commit();
        } catch(\Exception $e) {
            throw new DeleteMembroException();
        }
    }
}
