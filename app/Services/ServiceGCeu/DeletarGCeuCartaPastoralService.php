<?php 


namespace App\Services\ServiceGCeu;

use App\Exceptions\DeleteMembroException;
use App\Models\GCeuCartaPastoral;
use Illuminate\Support\Facades\DB;

class DeletarGCeuCartaPastoralService
{
    public function execute($id): void
    {
        try {
            DB::beginTransaction();
            $gceu = GCeuCartaPastoral::findOrFail($id);
            $gceu->update(['status' => GCeuCartaPastoral::STATUS_INATIVO, 'deleted_at' => date('Y-m-d H:m:s')]);
            $gceu->delete(); 
            DB::commit();
        } catch(\Exception $e) {
            throw new DeleteMembroException();
        }
    }
}
