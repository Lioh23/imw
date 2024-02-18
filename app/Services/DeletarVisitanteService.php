<?php

namespace App\Services;

use App\Models\MembresiaContato;
use App\Models\MembresiaMembro;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletarVisitanteService
{
    public function execute($membroId): bool
    {
        DB::beginTransaction();

        try {
            // Deleta o membro
            $membro = MembresiaMembro::findOrFail($membroId);
            $membro->delete();

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            // Log da exceção pode ser feito aqui
            return false;
        }
    }

}
