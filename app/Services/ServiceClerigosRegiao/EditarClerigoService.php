<?php

namespace App\Services\ServiceClerigosRegiao;

use App\Exceptions\MembroNotFoundException;
use App\Models\PessoasPessoa;
use App\Traits\Identifiable;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class EditarClerigoService
{
    use Identifiable;

    public function findOne($id)
    {
        $pessoa = PessoasPessoa::where('id', $id)->first();
        

        // Gerar URL temporária para a foto se estiver presente e o bucket for privado
        if ($pessoa->foto) {
            $disk = Storage::disk('s3');
            $pessoa->foto = $disk->temporaryUrl($pessoa->foto, Carbon::now()->addMinutes(1500));
        }
        return $pessoa;
    }
}
