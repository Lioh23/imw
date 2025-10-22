<?php 


namespace App\Services\ServiceGCeu;

use App\Exceptions\DeleteMembroException;
use App\Models\GCeu;
use Illuminate\Support\Facades\DB;

class DeletarGCeuService
{
    public function execute($gceuId): void
    {
        try {
            DB::beginTransaction();
            $gceu = GCeu::findOrFail($gceuId);
            $gceu->update(['status' => GCeu::STATUS_INATIVO, 'deleted_at' => date('Y-m-d H:m:s')]);
            $gceu->delete(); 
            DB::commit();
        } catch(\Exception $e) {
            throw new DeleteMembroException();
        }
    }
}
